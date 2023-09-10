<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable     =   [
        'ticketId',
        'customer',
        'lat',
        'lon',
        'address',
        'time',
        'price_delivery',
        'price_order',
        'order'
    ];
}
