<?php

namespace Ashan\StateMachine;

use Illuminate\Support\ServiceProvider;

class StateMachineServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../config/state_machine.php' => config_path('state_machine.php')
            ]
        );
    }
}
