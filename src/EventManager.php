<?php

namespace Event;

use Psr\EventManager\EventManagerInterface;
use Psr\EventManager\EventInterface;
use Event\Event;
use Event\ListenerQueue;

class EventManager implements EventManagerInterface
{
    private $listenersHeap = [];

    /**
     * Attaches a listener to an event
     *
     * @param string $event the event to attach too
     * @param callable $callback a callable function
     * @param int $priority the priority at which the $callback executed
     * @return bool true on success false on failure
     */
    public function attach($event, $callback, $priority = 0)
    {
        if (is_string($event)
        && is_callable($callback)
        && is_integer($priority)) {
            if (!array_key_exists($event, $this->listenersHeap)) {
                $this->listenersHeap[$event] = new ListenerQueue;
            }

            $this->listenersHeap[$event]->add($callback, $priority);

            return true;
        }

        return false;
    }

    /**
     * Detaches a listener from an event
     *
     * @param string $event the event to attach too
     * @param callable $callback a callable function
     * @return bool true on success false on failure
     */
    public function detach($event, $callback)
    {
        if (is_string($event) && is_callable($callback)) {
            if (array_key_exists($event, $this->listenersHeap)) {
                $this->listenersHeap[$event]->eject($callback);
            }

            return true;
        }

        return false;
    }

    /**
     * Clear all listeners for a given event
     *
     * @param  string $event
     * @return bool true on success false on failure
     */
    public function clearListeners($event)
    {
        if (is_string($event)) 
        {
            $this->listenersHeap[$event] = null;

            return true;
        }

        return false;
    }

    /**
     * Trigger an event
     *
     * Can accept an EventInterface or will create one if not passed
     *
     * @param  string|EventInterface $event
     * @param  object|string $target
     * @param  array|object $argv - arguments for listener callback
     * @return mixed
     */
    public function trigger($event, $target = null, $argv = [])
    {
        $result = false;

        if (is_string($event) || (is_object($event) && $event instanceof EventInterface)
        && (is_string($target) || is_object($target))
        && (is_array($argv) || is_object($argv))) {
            if (is_string($event)) {
                $event = new Event($event);
            }
        }

        if ($event->isPropagationStopped()) {
            return;
        }

        $event = $event->getName();

        $listeners = $this->listenersHeap[$event]->get();

        foreach ($listeners as $listener) {
            call_user_func_array(
                $listener['callback'],
                $argv
            );
        }

        return $result;
    }

    /**
     * Custom method for check event listeners
     *
     * @param string $event
     * @return bool true on success false on failure
     */
    public function isExistListeners($event)
    {
        if (is_string($event)) {
            if (is_null($this->listenersHeap[$event])) {
                return false;
            }
        }

        return true;
    }
}
