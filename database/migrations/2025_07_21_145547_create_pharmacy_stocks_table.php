<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pharmacy_stocks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->integer('pharmacy_id')->constrained('pharmacies')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->string('batch');
            $table->decimal('Purchase_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->date('expiration_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pharmacy_stocks');
    }
};
