<?php

namespace Event;

class ListenerQueue
{
    private $listeners = [];

    /**
     * Add listener to queue
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
     * Remove listener from listeners
     * 
     * 
     */
    public function eject($callback)
    {
        $flag = false;
        foreach($this->listeners as $key => $value)
        {
            $finded = in_array($callback, $value, true);
            if($finded)
            {
                unset($this->listeners[$key]);
                $flag =  true;
            }
        }

        $this->lsort();
        return $flag;
    }

    public function extract()
    {
        if($this->valid())
            unset($this->listeners[0]);

        $this->lsort();
    }

    /**
     * Validate listeners heap
     */
    public function valid()
    {
        if(sizeof($this->listeners) == 0)
            return false;

        return true;
    }

    /**
     * Clear listener queue
     */
    public function clear()
    {
        $this->listeners = [];
    }

    /**
     * Get maximum priority listener
     */
    public function top()
    {
        return array_shift($this->listeners)['callback'];
    }

    /**
     * Sorting listeners in priority
     */
    function lsort()
    {
        uasort($this->listeners, function($a, $b){
            if ($a['priority'] == $b['priority']) {
                return 0;
            }
            return ($a['priority'] > $b['priority']) ? -1 : 1;
        });
    }
}