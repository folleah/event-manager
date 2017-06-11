<?php

namespace Tests;

use Psr\EventManager\EventInterface;
use Event\Event;
use Tests\EventTestSuite;

final class EventTest extends EventTestSuite
{
    public function testCanEventObjectCreated()
    {
        $this->assertNotEmpty($this->event);
        $this->assertInstanceOf(EventInterface::class, $this->event);
        $this->assertObjectHasAttribute('name', $this->event);
        $this->assertObjectHasAttribute('params', $this->event);
        $this->assertObjectHasAttribute('target', $this->event);
        $this->assertObjectHasAttribute('isPropagationStopped', $this->event);
    }

    public function testSetAndGetEventParam()
    {
        $oneParam = 10;
        $twoParam = 'Hello';
        $twoParamEdited = 'World';

        $params = [
            'oneParam' => $oneParam,
            'twoParam' => $twoParam
        ];

        $this->event->setParams($params);
        
        $this->assertSame($this->event->getParams(), $params);
        $this->assertSame($this->event->getParam('oneParam'), $oneParam);
    }

    public function testSetAndGetEventTarget()
    {
        $target = (object) function () {
        };

        $this->event->setTarget($target);
        
        $this->assertSame($this->event->getTarget(), $target);
    }

    public function testSetAndGetEventPropagation()
    {
        $flag = true;

        $this->event->stopPropagation($flag);
        
        $this->assertTrue($this->event->isPropagationStopped());
    }

    public function testSetAndGetEventName()
    {
        $newName = "new.event.name";

        $this->event->setName($newName);
        
        $this->assertSame($this->event->getName(), $newName);
    }

    public function testSetEventInvalidNameBehavior()
    {
        $invalidName = "new%name";

        $this->assertRegExp('/[^(A-z0-9_.)]/', $invalidName);

        $this->expectException(\InvalidArgumentException::class);
        $this->event->setName($invalidName);
    }
}
