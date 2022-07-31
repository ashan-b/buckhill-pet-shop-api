<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Ashan\StateMachine\Traits\StateMachine;

class OrderController extends Controller {
    public function testState(\Illuminate\Http\Request $request)
    {

        $order = new Order;
//        $order = Order::find(1);
//        $order->uuid="123";

//        $order->setGraph($manage);
        $filename = "main_graph";
        $order->setGraph($filename);
//        dd($order->getCurrentState());
//        dd($order->getNextTransitions());
//        dd($order->can('state_0_to_state_1'));
        $order->process('state_0_to_state_2');

//dd($order->order_status_state);
//dd($order->order_status_id);
        $order->products=["UUID"=>"123"];
        $order->address=["address"=>"123"];
        $order->amount=100;
        $order->user_id=1;
        $order->payment_id=null;
//        $order->save();

        dd($order->getCurrentState());
//$order->setOrderStatusState("state_1");
//        $order->setConfig($config);
//        $order->setObject($order);
//
////        dd($order->getState());
////        dd($order->apply("state_1"));
//        dd($order->can("state_1"));
    }
}
