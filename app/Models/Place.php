<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'url',
        'status',
        'is_favorite',
        'is_lite',
        'is_classic',
        'is_amex',
        'has_delivery',
        'image_url',
        'logo_url',
        'name',
        'shortName',
        'main_category',
        'categories',
        'schedule',
        'score',
        'price_range',
        'location',
        'position',
        'isOutstanding'
    ];

    public function likes(){
        return $this->belongsToMany(Like::class, 'likes')->withTimestamps();
       }
}
