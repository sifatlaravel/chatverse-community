<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIChatService
{
    public function chat(array $messages): string
    {
        $apiKey = config('services.openai.key');
        $model = config('services.openai.model', 'gpt-4o-mini');

        if (!$apiKey) {
            return "OpenAI is not configured yet. Please set OPENAI_API_KEY in your .env.";
        }

        $res = Http::withToken($apiKey)
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.3,
            ]);

        if (!$res->successful()) {
            return "Sorry — I had trouble generating a response right now. Please try again.";

        }

        return (string) data_get($res->json(), 'choices.0.message.content', 'Sorry — no response.');
    }
}
