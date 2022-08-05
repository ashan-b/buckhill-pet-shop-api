<?php

namespace Ashan\StateMachine\Tests\Feature;
use Ashan\StateMachine\Models\TestModel;
use Tests\TestCase;

class ChangeStateOfTestModelTest extends TestCase
{
    /**
     * Set graph to order model
     * @return void
     */
    public function test_change_state_of_order_model()
    {
        $order = new TestModel();
        $order->setGraph("main_graph");

        //Test initial state
        $this->assertEquals("open", $order->getCurrentState()->getName());

        //Process to paid state
        $order->process("open_to_paid");
        $this->assertEquals("paid", $order->getCurrentState()->getName());

        //Set current state to shipped using UUID
        $order->changeCurrentStateByStatePrimaryKey("d2c9b721-13c3-35ba-a0b5-10e683958608");
        $this->assertEquals("shipped", $order->getCurrentState()->getName());

        // Check canChangeStateByTitle
        $this->assertFalse($order->canChangeStateByTitle("open"));

        // Check canChangeStateByPrimaryKey
        $this->assertTrue($order->canChangeStateByPrimaryKey("56e42c2d-1311-3f8f-b670-6ebe1ff50768")); //canceled
    }
}
