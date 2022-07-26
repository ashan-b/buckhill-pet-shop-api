<?php

namespace Ashan\StateMachine\Traits;

use Ashan\StateMachine\Exceptions\InvalidStateMachineTransition;
use Ashan\StateMachine\Models\State;
use Ashan\StateMachine\Models\Transition;

trait StateMachine
{
    protected $config = [];
    protected $graph = [];
    protected $propertyPath;
    protected $primaryKeyName;
    protected $propertyId;

    public function getPrimaryKeyName()
    {
        return $this->primaryKeyName;
    }

    public function getGraph()
    {
        return $this->graph;
    }

    public function setGraph($filename): void
    {
        $path = storage_path("/state_machine_graphs/${filename}.json");
        $graph = json_decode(file_get_contents($path));
        $this->graph = $graph;
        $this->propertyPath = $graph->property_path;
        $this->primaryKeyName = $graph->state_primary_key;
        $this->propertyId = $graph->property_id;
        //If model exists load the current state using propertyId.
        if ($this->exists) {
            $state = array_filter($graph->states, function ($e) { return property_exists($e, $this->primaryKeyName) && $e->{$this->primaryKeyName} === $this->{$this->propertyId};});
            if ($state !== null) {
                $this->changeCurrentState(head($state));
            }
        } else { //If model is new, load the initial property
            $defaultStateObject = array_filter( $graph->states, function ($e) { return property_exists($e, 'initial') && $e->initial === true; });
            if ($defaultStateObject !== null) {
                $this->changeCurrentState($defaultStateObject[0]);
            }
        }
    }

    private function changeCurrentState($stateObject): void
    {
        $state = new State($stateObject->title, $stateObject);
        $this->{$this->propertyPath} = $state;
        $this->{$this->propertyId} = $stateObject->{$this->primaryKeyName};
    }

    public function changeCurrentStateByStatePrimaryKey($primaryKey, $force = false): void
    {
        if ($force === false && !$this->canChangeStateByPrimaryKey($primaryKey)) {
            throw new InvalidStateMachineTransition(
                sprintf(
                    '"%s" cannot change the state from primary key "%s" to "%s" according to the graph "%s"',
                    static::class,
                    $this->getCurrentState()->getMetadata()->{$this->primaryKeyName},
                    $primaryKey,
                    $this->graph->graph
                )
            );
        }

        $stateT = array_filter(
            $this->graph->states,
            function ($e) use ($primaryKey) {
                return property_exists($e, $this->primaryKeyName) && $e->{$this->primaryKeyName} === $primaryKey;
            }
        );

        $this->changeCurrentState(head($stateT));
    }

    public function canChangeStateByPrimaryKey(string $primaryKey): bool
    {
        $transitionState = array_filter(
            $this->graph->states,
            function ($e) use ($primaryKey) {
                return property_exists($e, $this->primaryKeyName) && $e->{$this->primaryKeyName} === $primaryKey;
            }
        );
        return !empty($transitionState);
    }

    public function getCurrentState()
    {
        return $this->{$this->propertyPath};
    }

    public function process($nextTransition): bool
    {
        if (!$this->can($nextTransition)) {
            return false;
        }
        $nextTransitions = $this->getNextTransitions();
        $transitionState = array_filter(
            $nextTransitions,
            function ($e) use ($nextTransition) {
                return property_exists($e, 'name') && $e->getName() === $nextTransition;
            }
        );
        $this->changeCurrentStateByStateTitle(head($transitionState)->getResultingStateName(), true);
        return true;
    }

    public function can(string $nextTransition): bool
    {
        $nextTransitions = $this->getNextTransitions();
        $transitionState = array_filter(
            $nextTransitions,
            function ($e) use ($nextTransition) {
                return property_exists($e, 'name') && $e->getName() === $nextTransition;
            }
        );
        return !empty($transitionState);
    }

    public function getNextTransitions()
    {
        $availableTransitionsState = $this->graph->transitions->{$this->getCurrentState()->getName()}[0];
        $availableTransitions = $availableTransitionsState->to;
        $availableTransitionsArray = [];
        foreach ($availableTransitions as $availableTransition) {
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

    public function changeCurrentStateByStateTitle($title, $force = false): void
    {
        if ($force === false && !$this->canChangeStateByTitle($title)) {
            throw new InvalidStateMachineTransition(
                sprintf(
                    '"%s" cannot change the state from title "%s" to "%s" according to the graph "%s"',
                    static::class,
                    $this->getCurrentState()->getName(),
                    $title,
                    $this->graph->graph
                )
            );
        }
        $stateT = array_filter(
            $this->graph->states,
            function ($e) use ($title) {
                return property_exists($e, 'title') && $e->title === $title;
            }
        );
        $this->changeCurrentState(head($stateT));
    }

    public function canChangeStateByTitle(string $title): bool
    {
        $transitionState = array_filter(
            $this->graph->states,
            function ($e) use ($title) {
                return property_exists($e, $this->title) && $e->{$this->title} === $title;
            }
        );

        return !empty($transitionState);
    }
}
