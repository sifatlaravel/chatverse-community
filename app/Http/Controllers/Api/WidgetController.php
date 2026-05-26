<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bot;
use App\Models\Conversation;
use App\Models\Lead;
use App\Models\Message;
use App\Services\OpenAIChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WidgetController extends Controller
{
    public function config(string $key)
    {
        $bot = Bot::where('public_key', $key)->where('is_active', true)->firstOrFail();

        return response()->json([
            'bot' => [
                'public_key' => $bot->public_key,
                'is_demo' => (bool) $bot->is_demo,
                'bot_name' => $bot->bot_name,
                'company_name' => $bot->company_name,
                'welcome_message' => $bot->welcome_message,
                'theme' => [
                    'primary' => $bot->theme_primary ?: '#22c1ee',
                    'accent' => $bot->theme_accent ?: '#a855f7',
                    'bg' => $bot->theme_bg ?: '#0b1020',
                ],
                'brand_header' => 'Buddy by Chatverse',
                'avatar' => asset('assets/buddy-head-256.webp'),
            ],
            'embed' => [
                'api_base' => url('/api'),
            ],
        ]);
    }

    public function message(Request $request, OpenAIChatService $ai)
    {
        $data = $request->validate([
            'public_key' => ['required','string'],
            'text' => ['required','string','max:2000'],
            'conversation_id' => ['nullable','uuid'],
            'visitor_id' => ['nullable','string','max:128'],
            'origin' => ['nullable','string','max:255'],
        ]);

        $bot = Bot::where('public_key', $data['public_key'])->where('is_active', true)->firstOrFail();

        // optional domain allowlist
        if ($bot->allowed_domain && isset($data['origin'])) {
            $allowed = $bot->allowed_domain;
            if (!str_contains($data['origin'], $allowed)) {
                return response()->json(['error' => 'This bot is not allowed on this domain.'], 403);
            }
        }

        $conversation = null;
        if (!empty($data['conversation_id'])) {
            $conversation = Conversation::where('public_id', $data['conversation_id'])->where('bot_id', $bot->id)->first();
        }
        if (!$conversation) {
            $conversation = Conversation::create([
                'bot_id' => $bot->id,
                'public_id' => (string) Str::uuid(),
                'visitor_id' => $data['visitor_id'] ?? null,
            ]);
        }

        Message::create([
            'conversation_id' => $conversation->id,
            'role' => 'user',
            'content' => $data['text'],
        ]);

        $system = $this->systemPrompt($bot);
        $kb = $this->kbSnippet($bot);

        $messages = [
            ['role' => 'system', 'content' => $system],
        ];
        if ($kb) {
            $messages[] = ['role' => 'system', 'content' => "Business knowledge base:\n".$kb];
        }

        // include last few messages for context
        $recent = $conversation->messages()->latest()->take(8)->get()->reverse();
        foreach ($recent as $m) {
            if ($m->role === 'system') continue;
            $messages[] = ['role' => $m->role === 'assistant' ? 'assistant' : 'user', 'content' => $m->content];
        }

        $reply = trim($ai->chat($messages));

        Message::create([
            'conversation_id' => $conversation->id,
            'role' => 'assistant',
            'content' => $reply,
        ]);

        // lead trigger heuristics
        $needLead = $this->shouldAskLead($data['text'], $reply);

        return response()->json([
            'conversation_id' => $conversation->public_id,
            'reply' => $reply,
            'ask_lead' => $needLead,
        ]);
    }

    public function lead(Request $request)
    {
        $data = $request->validate([
            'public_key' => ['required','string'],
            'conversation_id' => ['nullable','uuid'],
            'name' => ['nullable','string','max:120'],
            'email' => ['nullable','email','max:255'],
            'phone' => ['nullable','string','max:64'],
            'message' => ['nullable','string','max:1000'],
        ]);

        $bot = Bot::where('public_key', $data['public_key'])->where('is_active', true)->firstOrFail();
        $conversation = null;
        if (!empty($data['conversation_id'])) {
            $conversation = Conversation::where('public_id', $data['conversation_id'])->where('bot_id', $bot->id)->first();
        }

        Lead::create([
            'bot_id' => $bot->id,
            'conversation_id' => $conversation?->id,
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'message' => $data['message'] ?? null,
        ]);

        return response()->json(['ok' => true]);
    }

    private function systemPrompt(Bot $bot): string
    {
        $botName = $bot->bot_name;
        $company = $bot->company_name ?: 'this business';

        if ($bot->is_demo) {
            return "You are Buddy by Chatverse, a friendly AI chatbot demo for businesses. Your job is to explain what Chatverse is, how it helps capture leads, and guide users to try the demo and view pricing. Be concise and helpful. If asked about pricing, recommend visiting /pricing. Never claim to be human.";
        }

        return "You are an AI website assistant named {$botName} for {$company}. Be concise, professional, and helpful. Use the provided knowledge base to answer. If you are unsure, say you are not sure and suggest contacting the business. When appropriate, ask for contact details to follow up.";
    }

    private function kbSnippet(Bot $bot): string
    {
        $kb = (string) $bot->knowledge_base;
        $kb = trim($kb);
        if ($kb === '') return '';
        // keep under ~3500 chars
        if (strlen($kb) > 3500) {
            $kb = substr($kb, 0, 3500) . "\n...(truncated)";

        }
        return $kb;
    }

    private function shouldAskLead(string $userText, string $reply): bool
    {
        $t = strtolower($userText . ' ' . $reply);
        $keywords = ['price','pricing','quote','contact','call','email','hire','purchase','buy','trial','demo','support'];
        foreach ($keywords as $k) {
            if (str_contains($t, $k)) return true;
        }
        return false;
    }
}
