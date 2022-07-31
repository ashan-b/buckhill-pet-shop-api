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

    protected $appends = ['order_status_state'];

    public function getOrderStatusStateAttribute()
    {
        if ($this->orderStatusState != null) {
            return $this->orderStatusState;
        }

        $order_status_id = $this->attributes['order_status_id'];
        if ($order_status_id !== null) {
            $orderStatus = OrderStatus::find($order_status_id);
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
        $this->attributes['order_status_id'] = $orderStatus->id;
    }

}
