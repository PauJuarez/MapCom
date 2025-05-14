<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ressenya extends Model
{
    protected $fillable = [
        'botiga_id', 'user_id', 'usuari', 'comentari', 'valoracio', 'dataPublicacio'
    ];

    public function botiga()
    {
        return $this->belongsTo(Botiga::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
