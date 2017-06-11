<?php

namespace Event;

use Psr\EventManager\EventInterface;
use Exception;

class Event implements EventInterface
{
    private $name;
    private $params = [];
    private $target;
    private $isPropagationStopped = false;

    /**
     * @param string $name 
     * @param array $params
     * @param object | string $target
     * @param bool $isPropagationStopped
     */
    public function __construct(
        $name,
        $params = [],
        $target = null,
        $isPropagationStopped = false
    )
    {
        $this->setName($name);
        $this->setParams($params);
        $this->setTarget($target);
        $this->stopPropagation($isPropagationStopped);
    }

    /**
     * Get event name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get target/context from which event was triggered
     *
     * @return null|string|object
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Get parameters passed to the event
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Get a single parameter by name
     *
     * @param  string $name
     * @return mixed
     */
    public function getParam($name)
    {
        return $this->params[$name];
    }

    /**
     * Set the event name
     *
     * @param  string $name
     * @return void
     */
    public function setName($name)
    {
        if (!$this->validateName($name)) {
            throw new Exception("Invalid event name format (Event name MUST contain \"A-z\", \"0-9\", \"_\", \".\"", 1);
        }

        $this->name = $name;
    }

    /**
     * Set the event target
     *
     * @param  null|string|object $target
     * @return void
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * Set event parameters
     *
     * @param  array $params
     * @return void
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * Indicate whether or not to stop propagating this event
     *
     * @param  bool $flag
     * @return void
     */
    public function stopPropagation($flag = true)
    {
        $this->isPropagationStopped = $flag;
    }

    /**
     * Has this event indicated event propagation should stop?
     *
     * @return bool
     */
    public function isPropagationStopped()
    {
        return $this->isPropagationStopped;
    }

    /**
     * Validate name with PSR specification
     * 
     * @param string $name
     * @return bool
     */
    private function validateName($name)
    {
        if (preg_match_all('/[^(A-z0-9_.)]/', $name, $matches, PREG_SET_ORDER, 0)) {
            return false;
        }

        return true;
    }
}