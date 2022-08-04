<?php

namespace Ashan\StateMachine\Tests;
use Ashan\StateMachine\Traits\StateMachine;
use Tests\TestCase;

class GraphTest extends TestCase
{
    /**
     * A basic test example.
     * @return void
     */
    public function test_graph()
    {
        $trait = $this->getObjectForTrait(StateMachine::class);

        $this->assertNull(null);
    }
}
