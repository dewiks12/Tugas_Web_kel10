<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->after('id')->constrained();
            $table->foreignId('branch_id')->after('role_id')->nullable()->constrained();
            $table->string('phone')->after('email')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('telegram_id')->nullable();
            $table->string('whatsapp')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['branch_id']);
            $table->dropColumn(['role_id', 'branch_id', 'phone', 'address', 'is_active', 'telegram_id', 'whatsapp']);
        });
    }
}; 