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
        Schema::create('repository_user_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_id')->constrained('permission')->cascadeondelete()->casecadeonupdate();
            $table->unsignedBigInteger('Repository_User_id')->constrained('Repository_User')->cascadeondelete()->casecadeonupdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repository_user_permissions');
    }
};
