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
        Schema::create('pharmaceutical_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');

            $table->string('name_ar');
            $table->string('image_path');
            $table->dropColumn(['created_at', 'updated_at']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmaceutical__forms');
    }
};
