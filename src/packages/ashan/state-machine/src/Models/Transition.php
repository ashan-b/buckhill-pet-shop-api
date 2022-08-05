<?php

namespace Ashan\StateMachine\Models;

class Transition
{
    private $name;
    private $initialStateName;
    private $resultingStateName;
    private $metadata;

    /**
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     */
    public function getInitialStateName(): string
    {
        return $this->initialStateName;
    }

    /**
     */
    public function setInitialStateName(string $initialStateName): void
    {
        $this->initialStateName = $initialStateName;
    }

    /**
     */
    public function getResultingStateName(): string
    {
        return $this->resultingStateName;
    }

    /**
     */
    public function setResultingStateName(string $resultingStateName): void
    {
        $this->resultingStateName = $resultingStateName;
    }

    /**
     */
    public function getMetadata(): mixed
    {
        return $this->metadata;
    }

    /**
     */
    public function setMetadata(mixed $metadata): void
    {
        $this->metadata = $metadata;
    }
}
