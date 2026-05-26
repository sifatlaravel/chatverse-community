<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BotController extends Controller
{
    public function index(Request $request)
    {
        $bots = $request->user()->bots()->latest()->get();
        return view('dashboard.bots.index', compact('bots'));
    }

    public function create(Request $request)
    {
        return view('dashboard.bots.create');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        // Enforce plan limits
        $limit = $user->subscription?->plan?->bot_limit ?? 0;
        if ($limit > 0 && $user->bots()->count() >= $limit) {
            return redirect()->route('bots.index')->with('error', 'Bot limit reached for your current plan.');
        }

        $data = $request->validate([
            'bot_name' => ['required','string','max:80'],
            'company_name' => ['nullable','string','max:120'],
            'allowed_domain' => ['nullable','string','max:255'],
            'theme_primary' => ['nullable','string','max:32'],
            'theme_accent' => ['nullable','string','max:32'],
            'theme_bg' => ['nullable','string','max:32'],
            'welcome_message' => ['nullable','string','max:600'],
            'knowledge_base' => ['nullable','string'],
        ]);

        $bot = Bot::create([
            'user_id' => $user->id,
            'public_key' => (string) Str::uuid(),
            'is_demo' => false,
            'bot_name' => $data['bot_name'],
            'company_name' => $data['company_name'] ?? null,
            'allowed_domain' => $data['allowed_domain'] ?? null,
            'theme_primary' => $data['theme_primary'] ?? '#22c1ee',
            'theme_accent' => $data['theme_accent'] ?? '#a855f7',
            'theme_bg' => $data['theme_bg'] ?? '#0b1020',
            'welcome_message' => $data['welcome_message'] ?? 'Hi! How can I help?',
            'knowledge_base' => $data['knowledge_base'] ?? '',
            'is_active' => true,
        ]);

        return redirect()->route('bots.edit', $bot)->with('status','Bot created.');
    }

    public function edit(Request $request, Bot $bot)
    {
        abort_unless($bot->user_id === $request->user()->id, 403);
        return view('dashboard.bots.edit', compact('bot'));
    }

    public function update(Request $request, Bot $bot)
    {
        abort_unless($bot->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'bot_name' => ['required','string','max:80'],
            'company_name' => ['nullable','string','max:120'],
            'allowed_domain' => ['nullable','string','max:255'],
            'theme_primary' => ['nullable','string','max:32'],
            'theme_accent' => ['nullable','string','max:32'],
            'theme_bg' => ['nullable','string','max:32'],
            'welcome_message' => ['nullable','string','max:600'],
            'knowledge_base' => ['nullable','string'],
            'is_active' => ['nullable'],
        ]);

        $bot->fill($data);
        $bot->is_active = $request->boolean('is_active');
        $bot->save();

        return back()->with('status','Bot updated.');
    }
}
