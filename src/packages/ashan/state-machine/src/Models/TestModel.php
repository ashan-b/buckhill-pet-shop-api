<?php


namespace Ashan\StateMachine\Models;


use Ashan\StateMachine\Traits\StateMachine;
use Illuminate\Database\Eloquent\Model;

/**
 * Ashan\StateMachine\Models\TestModel
 *
 * @property mixed $order_status_state
 * @method static \Illuminate\Database\Eloquent\Builder|TestModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestModel query()
 * @mixin \Eloquent
 */
class TestModel extends Model
{
    use StateMachine;

    private $orderStatusState;

    protected $fillable = [
        'order_status_uuid'
    ];

    protected $hidden = [
        'order_status_state'
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

}
