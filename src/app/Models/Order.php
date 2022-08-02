<?php

namespace App\Models;

use Ashan\StateMachine\Traits\StateMachine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use StateMachine;

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
        'payment_id' => 'string',
        'delivery_fee' => 'double',
        'amount' => 'double',
        'shipped_at' => 'datetime'
    ];

    protected $appends = ['order_status_state'];

    public function getOrderStatusStateAttribute()
    {
        if ($this->orderStatusState != null) {
            return $this->orderStatusState;
        }

        $order_status_uuid = $this->attributes['order_status_uuid'];
        if ($order_status_uuid !== null) {
            $orderStatus = OrderStatus::where("uuid",$order_status_uuid)->first();
            $this->setCurrentStateByStatePrimaryKey($orderStatus->{$this->primaryKeyName});
        }

        return $this->orderStatusState;
    }

    public function setOrderStatusStateAttribute($orderStatusState)
    {
        $this->orderStatusState = $orderStatusState;
        $orderStatus = OrderStatus::where(
            $this->primaryKeyName,
            $orderStatusState->getMetadata()->{$this->getPrimaryKeyName()}
        )->first();
        $this->attributes['order_status_uuid'] = $orderStatus->{$this->primaryKeyName};
    }

}
