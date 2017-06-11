## PSR-7 Events implementation [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Folleah/psr7-event-emitter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Folleah/psr7-event-emitter/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/Folleah/psr7-event-emitter/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Folleah/psr7-event-emitter/build-status/master)

[FIG standart link](https://github.com/php-fig/fig-standards/blob/master/proposed/event-manager.md)

**Some examples:**
- Security framework that will prevent saving/accessing data when a user doesn't have permission.
- A Common full page caching system
- Logging package to track all actions taken within the application

**Example:**
```php
use Event\Event;
use Event\EventManager;

$onGreeted = function($var) {
    echo "Hi, {$var}.</br>";
};

$onAsked = function() {
    echo "How are you?</br>";
};

$onGoodbye = function() {
    echo "Bye!</br>";
};

$eventManager = new EventManager;
$event = new Event('acquaintance');

// Listen this event with priority
$eventManager->attach('acquaintance', $onGreeted, 2);
$eventManager->attach('acquaintance', $onAsked, 1);
$eventManager->attach('bye', $onGoodbye);

/**
 * Call created event
 * 
 * output:
 * Hi, Alice.
 * How are you?
 */
$eventManager->trigger($event, null, ['Alice']); // 'Alice' will be passed as argument to the listener callback

/**
 * Create new event and call it
 * 
 * output:
 * Bye!
 */
$newEvent = $eventManager->trigger('bye');
```


With the `stopPropagation()` method, you can stop calling the remaining listeners

**Event stop propagation example:**
```php
$eventManager = new EventManager;

$helloWorld = function() {
    echo "Hello world!";
};

$eventManager->attach('hello.world', $helloWorld);

$event = $eventManager->trigger('hello.world');
$event->stopPropagation();
// It will not work
$event = $eventManager->trigger('hello.world');
```

**License: [MIT](https://github.com/Folleah/psr7-event-emitter/blob/master/README.md)**