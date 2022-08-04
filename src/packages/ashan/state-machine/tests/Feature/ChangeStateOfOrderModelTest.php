<?php

namespace Ashan\StateMachine\Tests;
use App\Models\Order;
use Tests\TestCase;

class ChangeStateOfOrderModelTest extends TestCase
{
    /**
     * Set graph to order model
     * @return void
     */
    public function test_change_state_of_order_model()
    {
        $order = new Order;
        $order->setGraph("main_graph");
        $this->assertEquals("open", $order->getCurrentState()->getName());

        $order->process("open_to_paid");
        $this->assertEquals("paid", $order->getCurrentState()->getName());

        $order->setCurrentStateByStatePrimaryKey("d2c9b721-13c3-35ba-a0b5-10e683958608");
        $this->assertEquals("shipped", $order->getCurrentState()->getName());

        $this->assertFalse($order->canChangeStateByTitle("open"));
        $this->assertTrue($order->canChangeStateByPrimaryKey("56e42c2d-1311-3f8f-b670-6ebe1ff50768")); //canceled
    }
}
