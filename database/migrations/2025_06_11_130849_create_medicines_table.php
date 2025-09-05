<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->text('trade_name');
            $table->text('laboratory_id')->nullable();
            //                ->constrained('laboratories')->casecadeonupdate()->casecadeondelete();

            $table->text('composition');
            $table->text('titer');
            $table->text('packaging');
            $table->text('pharmaceutical_form_id')->nullable();
            $table->string('code')->nullable();
//                ->constrained('pharmaceutical_form')->casecadeonupdate()->casecadeondelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
