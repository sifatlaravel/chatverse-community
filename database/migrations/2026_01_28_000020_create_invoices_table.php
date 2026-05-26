<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->string('payment_method')->default('bank_transfer'); // bank_transfer|bkash
            $table->unsignedInteger('amount_cents')->default(0);
            $table->string('currency', 8)->default('USD');
            $table->string('status')->default('pending'); // pending|approved|rejected
            $table->string('reference')->nullable(); // tx id
            $table->string('proof_path')->nullable(); // uploaded proof
            $table->text('admin_note')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
