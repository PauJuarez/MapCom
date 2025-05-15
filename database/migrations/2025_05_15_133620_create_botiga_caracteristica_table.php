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
        Schema::create('botiga_caracteristica', function (Blueprint $table) {
            $table->unsignedBigInteger('botiga_id');
            $table->unsignedBigInteger('caracteristica_id');

            $table->foreign('botiga_id')->references('id')->on('botigues')->onDelete('cascade');
            $table->foreign('caracteristica_id')->references('id')->on('caracteristiques')->onDelete('cascade');

            $table->primary(['botiga_id', 'caracteristica_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('botiga_caracteristica');
    }
};
