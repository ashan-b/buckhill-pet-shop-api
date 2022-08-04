<?php

namespace App\Models;

use App\Http\Traits\HasUuid;
use Ashan\StateMachine\Traits\StateMachine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use StateMachine;
    use HasUuid;

    private $orderStatusState;

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
        'user_uuid',
        'order_status_uuid',
        'payment_uuid'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'order_status_state'
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
        'user_uuid' => 'string',
        'order_status_uuid' => 'string',
        'payment_uuid' => 'string',
        'delivery_fee' => 'double',
        'amount' => 'double',
        'shipped_at' => 'datetime'
    ];

    protected $appends = ['order_status_state'];

    public function getOrderStatusStateAttribute()
    {
        return $this->orderStatusState;
    }

    public function setOrderStatusStateAttribute($orderStatusState)
    {
        $this->orderStatusState = $orderStatusState;
    }


    public function user()
    {
        return $this->hasOne(User::class, 'uuid', 'user_uuid');
    }

    public function orderStatus()
    {
        return $this->hasOne(OrderStatus::class, 'uuid', 'order_status_uuid');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'uuid', 'payment_uuid');
    }

}
