<?php

namespace Ashan\StateMachine\Traits;

use Ashan\StateMachine\Models\State;
use Ashan\StateMachine\Models\Transition;

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
            if ($state !== null) {
                $this->setCurrentState(head($state));
            }
        } else {
            $defaultStateObject = array_filter(
                $graph->states,
                function ($e) {
                    return (property_exists($e, 'initial') && $e->initial == true);
                }
            );
            if ($defaultStateObject !== null) {
                $this->setCurrentState($defaultStateObject[0]);
            }
        }
    }

    private function setCurrentState($stateObject)
    {
        $state = new State($stateObject->title, $stateObject);
        $this->{$this->property_path} = $state;
    }

    public function setCurrentStateByStatePrimaryKey($primaryKey)
    {
        $stateT = array_filter(
            $this->graph->states,
            function ($e) use ($primaryKey) {
                return (
                    property_exists($e, $this->primaryKeyName)
                    &&
                    $e->{$this->primaryKeyName} ==
                    $primaryKey);
            }
        );

        $this->setCurrentState(head($stateT));
    }

    public function setCurrentStateByStateTitle($title)
    {
        $stateT = array_filter(
            $this->graph->states,
            function ($e) use ($title) {
                return (
                    property_exists($e, 'title')
                    &&
                    $e->title ==
                    $title);
            }
        );

        $this->setCurrentState(head($stateT));
    }

    public function getCurrentState()
    {
        return $this->{$this->property_path};
    }

    public function getNextTransitions()
    {
        $availableTransitionsState = $this->graph->transitions->{$this->getCurrentState()->getName()}[0];
        $availableTransitions = $availableTransitionsState->to;

        $availableTransitionsArray = [];
        foreach ($availableTransitions as $availableTransition) {
            $transitionState = array_filter(
                $this->graph->states,
                function ($e) use ($availableTransition) {
                    return (property_exists($e, 'title') && $e->title == $availableTransition);
                }
            );
            $transitionName = $this->getCurrentState()->getName() . "_to_" . $availableTransition;

            $transition = new Transition();
            $transition->setName($transitionName);
            $transition->setMetadata($availableTransitionsState);
            $transition->setInitialStateName($this->getCurrentState()->getName());
            $transition->setResultingStateName($availableTransition);

            $availableTransitionsArray[$transitionName] = $transition;
        }
        return $availableTransitionsArray;
    }

    public function process($nextTransition)
    {
        if (!$this->can($nextTransition)) {
            return false;
        }
        $nextTransitions = $this->getNextTransitions();
        $transitionState = array_filter(
            $nextTransitions,
            function ($e) use ($nextTransition) {
                return (property_exists($e, 'name') && $e->getName() == $nextTransition);
            }
        );
        $this->setCurrentStateByStateTitle(head($transitionState)->getResultingStateName());
        return true;
    }

    public function can(string $nextTransition)
    {
        $nextTransitions = $this->getNextTransitions();
        $transitionState = array_filter(
            $nextTransitions,
            function ($e) use ($nextTransition) {
                return (property_exists($e, 'name') && $e->getName() == $nextTransition);
            }
        );

        return !empty($transitionState);
    }

}
