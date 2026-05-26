<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company')->nullable()->after('name');
            $table->string('timezone')->nullable()->after('company');
            $table->boolean('is_admin')->default(false)->after('timezone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['company', 'timezone', 'is_admin']);
        });
    }
};
