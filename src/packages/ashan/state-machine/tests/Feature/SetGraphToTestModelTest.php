<?php

namespace Ashan\StateMachine\Tests\Feature;
use Ashan\StateMachine\Models\TestModel;
use Tests\TestCase;

class SetGraphToTestModelTest extends TestCase
{
    /**
     * Set graph to order model
     * @return void
     */
    public function test_set_graph_to_test_model()
    {
        $order = new TestModel();
        $order->setGraph("main_graph");
        self::assertEquals("main_graph", $order->getGraph()->graph);
    }
}
