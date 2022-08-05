<?php

namespace Ashan\StateMachine\Models;

/**
 * Class State
 * @package Ashan\StateMachine\Models
 */
class State
{
    protected $name;
    protected $metadata;

    /**
     * State constructor.
     * @param $name
     * @param $metadata
     */
    public function __construct($name, $metadata)
    {
        $this->name = $name;
        $this->metadata = $metadata;
    }

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
