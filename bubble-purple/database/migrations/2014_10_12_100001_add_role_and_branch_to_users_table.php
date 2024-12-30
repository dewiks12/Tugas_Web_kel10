<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('telegram_id')->nullable();
            $table->string('whatsapp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['branch_id']);
            $table->dropColumn([
                'role_id',
                'branch_id',
                'is_active',
                'phone',
                'address',
                'telegram_id',
                'whatsapp'
            ]);
        });
    }
}; 