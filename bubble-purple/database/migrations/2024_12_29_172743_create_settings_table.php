<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'site_name',
                'value' => 'Bubble Purple Laundry',
                'group' => 'general',
                'description' => 'Website name'
            ],
            [
                'key' => 'theme',
                'value' => 'light',
                'group' => 'appearance',
                'description' => 'Website theme (light/dark)'
            ],
            [
                'key' => 'email_notifications',
                'value' => 'true',
                'group' => 'notifications',
                'description' => 'Enable email notifications'
            ],
            [
                'key' => 'whatsapp_notifications',
                'value' => 'true',
                'group' => 'notifications',
                'description' => 'Enable WhatsApp notifications'
            ],
            [
                'key' => 'telegram_notifications',
                'value' => 'true',
                'group' => 'notifications',
                'description' => 'Enable Telegram notifications'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
