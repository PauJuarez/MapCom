<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('botigues', function (Blueprint $table) {
            $table->date('horariObertura')->nullable();
            $table->date('horariTencament')->nullable(); // corregido
            $table->integer('telefono')->nullable(); // corregido
            $table->string('coreoelectronic')->nullable();
            $table->string('web')->nullable();
            $table->string('imatge')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('botigues', function (Blueprint $table) {
            $table->dropColumn('nova_columna');
        });
    }
};

