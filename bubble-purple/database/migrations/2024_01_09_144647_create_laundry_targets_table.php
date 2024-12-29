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
        Schema::create('laundry_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->decimal('target_amount', 12, 2);
            $table->decimal('achieved_amount', 12, 2)->default(0);
            $table->integer('target_orders');
            $table->integer('achieved_orders')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laundry_targets');
    }
}; 