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
        Schema::create('ressenyas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('botiga_id');
            $table->unsignedBigInteger('user_id'); 
            $table->string('usuari');
            $table->text('comentari');
            $table->tinyInteger('valoracio');
            $table->timestamp('dataPublicacio')->nullable();
            $table->timestamps();

            $table->foreign('botiga_id')->references('id')->on('botigues')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ressenyas');
    }
};
