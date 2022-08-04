<?php

namespace Ashan\StateMachine\Tests;
use App\Models\Order;
use Tests\TestCase;

class SetGraphToOrderModelTest extends TestCase
{
    /**
     * Set graph to order model
     * @return void
     */
    public function test_set_graph_to_order_model()
    {
        $order = new Order;
        $order->setGraph("main_graph");
        self::assertEquals("main_graph", $order->getGraph()->graph);
    }
}
