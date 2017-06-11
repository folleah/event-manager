<?php

namespace Tests;

use Psr\EventManager\EventInterface;
use Psr\EventManager\EventManagerInterface;
use Event\Event;
use Event\EventManager;
use Tests\EventTestSuite;

final class EventManagerTest extends EventTestSuite
{
    public function testCanListenerReturnTrue()
    {
        $this->assertTrue(call_user_func($this->eventListener));
    }

    public function testCanEventManagerObjectCreated()
    {
        $this->assertNotEmpty($this->eventManager);
    }

    public function testCanAttachEventToEventManager()
    {
        $this->assertTrue($this->eventManager->attach($this->event->getName(), $this->eventListener));
    }

    public function testCanInvalidAttachEventToEventManager()
    {
        $this->assertFalse($this->eventManager->attach($this->event->getName(), null));
    }

    public function testCanDetachEventFromEventManager()
    {
        $this->assertTrue($this->eventManager->attach($this->event->getName(), $this->eventListener));

        $this->assertTrue($this->eventManager->detach($this->event->getName(), $this->eventListener));
    }

    public function testCanClearAllListenersFromEvent()
    {
        $this->eventManager->attach($this->event->getName(), $this->eventListener);

        $this->assertTrue($this->eventManager->clearListeners($this->event->getName()));

        $this->assertFalse($this->eventManager->isExistListeners($this->event->getName()));
    }
}
