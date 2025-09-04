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
        Schema::create('repository_stocks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->integer('repository_id')->constrained('pharmacies')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->string('batch');
            $table->decimal('Purchase_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->date('expiration_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repository_stocks');
    }
};
