<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'place_id',
        'client_name',
        'client_lastname',
        'reservation_date',
        'reservation_time'
    ];


}
