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
        Schema::table('pharmacy_stocks', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->foreign('batch_id')->references('id')->on('batches')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pharmacy_stocks', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->foreign('batch_id')->references('id')->on('batches');
        });
    }
};
