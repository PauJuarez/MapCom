<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    protected $table = 'caracteristiques';
    protected $fillable = ['nom'];

    public function botigues()
    {
        return $this->belongsToMany(Botiga::class, 'botiga_caracteristica', 'caracteristica_id', 'botiga_id');
    }




}