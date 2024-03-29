<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'place_id';
    protected $fillable = [
        'place_id',
        'slug',
        'is_lite',
        'is_classic',
        'is_favorite',
        'is_amex',
        'isOutstanding',
        'has_delivery',
        'reservable',
        'name',
        'description',
        'main_img',
        'logo_img',
        'gallery',
        'range_price',
        'status',
        'schedules',
        'amenities',
        'reservations',

    ];


    protected $casts = [
        'reservations' => 'array',
        'amenities' => 'array',
        'schedules' => 'array',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
