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
        Schema::create('pharmacy_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->constrained('users')->ondelete('cascade')->onupdate('cascade');
            $table->unsignedBigInteger('pharmacy_id')->constrained('pharmacies')->ondelete('cascade')->onupdate('cascade');
            $table->string('role')->required()->default('viewer');
            $table->boolean('is_work')->required()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacy_users');
    }
};
