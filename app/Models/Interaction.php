<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    use HasFactory;
    protected $fillable = ['place_id', 'user_id']; // Campos que pueden ser llenados en masa

    // Relación con el modelo Place
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
