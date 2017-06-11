<?php

namespace Event;

class ListenerQueue
{
    private $listeners = [];

    /**
     * Add listener to queue with priority
     *
     * @param callable $callback
     * @param int $priority
     * @return void
     */
    public function add($callback, $priority)
    {
        $this->eject($callback);

        $this->listeners[] = [
            'callback' => $callback,
            'priority' => $priority
        ];

        $this->lsort();
    }

    /**
     * Get listeners array
     *
     * @return array
     */
    public function get()
    {
        return $this->listeners;
    }

    /**
     * Remove listener from listeners
     *
     * @param callable $callback
     * @return bool true on success false on failure
     */
    public function eject($callback)
    {
        foreach ($this->listeners as $key => $value) {
            $finded = in_array($callback, $value, true);
            if ($finded) {
                unset($this->listeners[$key]);
            }
        }

        $this->lsort();
    }

    /**
     * Sorting listeners in priority
     *
     * @return void
     */
    private function lsort()
    {
        uasort($this->listeners, function ($a, $b) {
            if ($a['priority'] == $b['priority']) {
                return 0;
            }
            return ($a['priority'] > $b['priority']) ? -1 : 1;
        });
    }
}
