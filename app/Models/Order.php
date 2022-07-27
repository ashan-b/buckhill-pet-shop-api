<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'products',
        'address',
        'delivery_fee',
        'amount',
        'shipped_at',
        'user_id',
        'order_status_id',
        'payment_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uuid' => 'string',
        'products' => 'array',
        'address' => 'array',
        'user_id' => 'integer',
        'order_status_id' => 'integer',
        'payment_id' => 'integer',
        'delivery_fee' => 'double',
        'amount' => 'double',
        'shipped_at' => 'datetime'
    ];
}
