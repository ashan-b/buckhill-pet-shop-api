<?php

namespace App\Models;

use App\Http\Traits\HasUuid;
use Ashan\StateMachine\Traits\StateMachine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $uuid
 * @property array $products
 * @property array $address
 * @property float|null $delivery_fee
 * @property float $amount
 * @property string $user_uuid
 * @property string $order_status_uuid
 * @property string $payment_uuid
 * @property \Illuminate\Support\Carbon|null $shipped_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $order_status_state
 * @property-read \App\Models\OrderStatus|null $orderStatus
 * @property-read \App\Models\Payment|null $payment
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderStatusUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUuid($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;
    use StateMachine;
    use HasUuid;

    protected $orderStatusState;

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
        'payment_uuid',
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
        'shipped_at' => 'datetime',
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
