<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Botiga extends Model
{
    protected $table = 'botigues'; // Tabla en plural (por defecto Laravel esperaría "botigas")
    protected $fillable = ['nom', 'descripcio', 'adreca', 'latitud', 'longitud','horariObertura','horariTencament','telefono','coreoelectronic','web','imatge'];

    public function ressenyes()
    {
        return $this->hasMany(Ressenya::class);
    }
    public function caracteristiques()
    {
        return $this->belongsToMany(Caracteristica::class, 'botiga_caracteristica', 'botiga_id', 'caracteristica_id');
        // 'botiga_caracteristica' es la tabla pivote que une ambas tablas
    }


}