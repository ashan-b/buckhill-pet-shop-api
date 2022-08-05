<?php

namespace Ashan\StateMachine;

use Illuminate\Support\ServiceProvider;

class StateMachineServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([__DIR__ . '/../config/state_machine.php' => config_path('state_machine.php'),]);

        $this->publishes([__DIR__ . '/../state_machine_graphs' => storage_path('state_machine_graphs'),]);
    }
}
