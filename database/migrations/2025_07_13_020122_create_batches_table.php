<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines')->cascadeOnDelete();
            $table->string('batch_no');
            $table->date('expiry_date');
            $table->integer('initial_qty');
            $table->timestamps();
            $table->index(['medicine_id', 'expiry_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('batches');
    }
};
