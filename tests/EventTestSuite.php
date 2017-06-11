<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Event\Event;
use Event\EventManager;

class EventTestSuite extends TestCase
{
    protected $event;
    protected $eventManager;
    protected $eventListener;

    protected function setUp()
    {
        $this->eventManager = new EventManager;
        $this->event = new Event('some.event', [], 'someTarget', true);
        $this->eventListener = function () {
            return true;
        };
    }
    
    protected function tearDown()
    {
        unset($this->event);
        unset($this->eventManager);
        unset($this->eventListener);
    }
}
