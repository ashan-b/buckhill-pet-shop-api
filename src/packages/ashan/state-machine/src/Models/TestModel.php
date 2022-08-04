<?php


namespace Ashan\StateMachine\Models;


use Ashan\StateMachine\Traits\StateMachine;
use Illuminate\Database\Eloquent\Model;

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
