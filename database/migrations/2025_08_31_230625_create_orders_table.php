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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_id')->constrained('pharmacies')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('repository_id')->constrained('repositories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('order_num');
            $table->enum('status',
                ['pending', 'approved', 'rejected', 'delivered', 'canceled'])->default('pending');
            $table->decimal('total_price', 12, 2)->nullable();
            $table->decimal('paid', 12, 2)->nullable();
            $table->decimal('remaining', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
