<?php

namespace Event\Tests;

use PHPUnit\Framework\TestCase;
use Event\Event;

final class EventTest extends TestCase
{
    public function testEventCantCreateNotWithAString()
    {
        $eventName = 2;

        $event = new Event($eventName);

        $this->assertEmpty($event);
    }


}
