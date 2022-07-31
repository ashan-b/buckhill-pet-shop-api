<?php


namespace Ashan\StateMachine\Models;


class State
{
private $name;
private $metadata;

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param mixed $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }


}
