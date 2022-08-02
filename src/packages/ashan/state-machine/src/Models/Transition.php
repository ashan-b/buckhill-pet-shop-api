<?php


namespace Ashan\StateMachine\Models;


class Transition
{
    private $name;
    private $initialStateName;
    private $resultingStateName;
    private $metadata;

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
     * @return string
     */
    public function getInitialStateName()
    {
        return $this->initialStateName;
    }

    /**
     * @param string $initialStateName
     */
    public function setInitialStateName($initialStateName)
    {
        $this->initialStateName = $initialStateName;
    }

    /**
     * @return string
     */
    public function getResultingStateName()
    {
        return $this->resultingStateName;
    }

    /**
     * @param string $resultingStateName
     */
    public function setResultingStateName($resultingStateName)
    {
        $this->resultingStateName = $resultingStateName;
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
