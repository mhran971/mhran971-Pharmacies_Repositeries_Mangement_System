<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alternatives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medicine_id_1');
            $table->unsignedBigInteger('medicine_id_2');
            $table->timestamps();
            $table->dropColumn(['created_at', 'updated_at']);

            $table->foreign('medicine_id_1')->references('id')->on('medicines')->onDelete('cascade');
            $table->foreign('medicine_id_2')->references('id')->on('medicines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternatives');
    }
};
