<?php

namespace Event;

class ListenerQueue
{
    private $listeners = [];

    public function listen($callback, $priority)
    {
        $this->listeners[] = [
            'callback' => $callback,
            'priority' => $priority
        ];
    }

    public function extract($callback)
    {
        foreach($this->listeners as $key => $value)
        {
            $finded = array_search($callback, $value);
            if($finded) unset($this->listeners[$key]);
        }
    }

    public function valid()
    {
        if(sizeof($this->listeners) == 0)
            return false;

        return true;
    }

    public function clear()
    {
        $this->listeners = [];
    }


}