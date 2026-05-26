<?php

namespace Database\Seeders;

use App\Models\Bot;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Plans
        $starter = Plan::firstOrCreate(['code' => 'starter'], [
            'name' => 'Starter',
            'bot_limit' => 1,
            'site_limit' => 1,
            'monthly_price_cents' => 1900,
            'currency' => 'USD',
            'is_active' => true,
        ]);

        Plan::firstOrCreate(['code' => 'pro'], [
            'name' => 'Pro',
            'bot_limit' => 5,
            'site_limit' => 5,
            'monthly_price_cents' => 4900,
            'currency' => 'USD',
            'is_active' => true,
        ]);

        Plan::firstOrCreate(['code' => 'agency'], [
            'name' => 'Agency',
            'bot_limit' => 20,
            'site_limit' => 20,
            'monthly_price_cents' => 9900,
            'currency' => 'USD',
            'is_active' => true,
        ]);

        // Admin
        $admin = User::firstOrCreate(['email' => 'admin@chatverse.test'], [
            'name' => 'Admin',
            'company' => 'Chatverse',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        Subscription::firstOrCreate(['user_id' => $admin->id], [
            'plan_id' => $starter->id,
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addYear(),
        ]);

        // Demo bot (no owner)
        Bot::firstOrCreate(['is_demo' => true], [
            'user_id' => null,
            'public_key' => (string) Str::uuid(),
            'bot_name' => 'Chatverse Demo',
            'company_name' => 'Chatverse',
            'allowed_domain' => null,
            'theme_primary' => '#22c1ee',
            'theme_accent' => '#a855f7',
            'theme_bg' => '#0b1020',
            'welcome_message' => 'Hi! I\'m Buddy by Chatverse. Ask me what Chatverse does, then try the embed code.',
            'knowledge_base' => "Chatverse helps businesses capture leads via AI chat on their website.\n\nKey features:\n- 2-line embed\n- Knowledge base replies\n- Lead capture form\n\nIf user asks pricing, direct them to /pricing.",
            'is_active' => true,
        ]);
    }
}
