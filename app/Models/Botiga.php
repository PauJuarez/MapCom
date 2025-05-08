<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Botiga extends Model
{
    protected $table = 'botigues'; // Tabla en plural (por defecto Laravel esperaría "botigas")
    protected $fillable = ['nom', 'descripcio', 'adreca', 'latitud', 'longitud'];
}