<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Reservation extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'vehicle_name',
        'start_date',
        'end_date',
        'days',
        'total_price',
        'status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'notes',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'vehicle_id' => 'integer',
        'days' => 'integer',
        'total_price' => 'float',
    ];
}