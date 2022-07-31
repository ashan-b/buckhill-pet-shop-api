<?php

namespace Ashan\StateMachine\Traits;

trait StateMachine
{
    protected $config = [];
    protected $graph = [];
    protected $property_path;
    protected $primaryKeyName;

    public function getPrimaryKeyName()
    {
        return $this->primaryKeyName;
    }

    public function setGraph($filename)
    {
        $path = storage_path("/state_machine_graphs/${filename}.json");
        $graph = json_decode(file_get_contents($path));

        $this->graph = $graph;
        $this->property_path = $graph->property_path;
        $this->primaryKeyName = $graph->state_primary_key;

        //Set default state
        if ($this->exists) {//If model exists load the current state.

            $state = array_filter(
                $graph->states,
                function ($e) {
                    return (
                        property_exists($e, $this->primaryKeyName)
                        &&
                        $e->{$this->primaryKeyName} ==
                        $this->{$this->property_path}->getMetadata()->{$this->primaryKeyName});
                }
            );
        } else {
            $defaultStateObject = array_filter(
                $graph->states,
                function ($e) {
                    return (property_exists($e, 'initial') && $e->initial == true);
                }
            );
        }
    }

}
