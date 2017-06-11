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
        if (!is_string($event) 
        && !is_callable($callback) 
        && !is_integer($priority)) {
            return false;
        }

        if (!array_key_exists($event, $this->listenersHeap)) {
            $this->listenersHeap[$event] = new ListenerQueue;
        }

        $this->listenersHeap[$event]->add($callback, $priority);
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
        if (!is_string($event) && !is_callable($callback)) {
            return false;
        }

        if (array_key_exists($event, $this->listenersHeap)) {
            $this->listenersHeap[$event]->eject($callback);
        }

        return true;
    }

    /**
     * Clear all listeners for a given event
     *
     * @param  string $event
     * @return bool true on success false on failure
     */
    public function clearListeners($event)
    {
        if (!is_string($event)) {
            return false;
        }

        $this->listenersHeap[$event]->clear();
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
        if (!is_string($event) && !is_object($event)
        && !is_string($target) && !is_object($target)
        && !is_array($argv) && !is_object($argv)) {
            return false;
        }

        if (is_string($event)) {
            $event = new Event($event);
        } 

        if ($event instanceof EventInterface) {
            if ($event->isPropagationStopped()) {
                return;
            }

            $event = $event->getName();
        }

        $listeners = $this->listenersHeap[$event]->get();

        foreach ($listeners as $listener)
        {
            call_user_func_array(
                $listener['callback'], 
                $argv
            );
        }

        return $event;
    }
}
