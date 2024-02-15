<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable = [
        'place_id',
    ];

    public function likes(){
     return $this->belongsToMany(Like::class, 'likes')->withTimestamps();
    }
}
