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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('pharmacy_id');
            $table->string('user_id');
            $table->string('costumer_fullName')->default('');
            $table->string('National_number')->default('');
            $table->double('invoice_num');
            $table->double('total_sum');
            $table->boolean('Psychiatric')->default(0);
            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
