<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // null for demo bot
            $table->string('public_key')->unique();
            $table->boolean('is_demo')->default(false);

            $table->string('bot_name');
            $table->string('company_name')->nullable();
            $table->string('allowed_domain')->nullable(); // optional allowlist

            $table->string('theme_primary')->nullable();
            $table->string('theme_accent')->nullable();
            $table->string('theme_bg')->nullable();

            $table->text('welcome_message')->nullable();
            $table->longText('knowledge_base')->nullable(); // FAQ + info
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bots');
    }
};
