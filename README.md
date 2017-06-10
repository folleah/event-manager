## PSR-7 Events implementation [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Folleah/psr7-event-emitter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Folleah/psr7-event-emitter/?branch=master)

[FIG standart link](https://github.com/php-fig/fig-standards/blob/master/proposed/event-manager.md)

**Some examples:**
- Security framework that will prevent saving/accessing data when a user doesn't have permission.
- A Common full page caching system
- Logging package to track all actions taken within the application

**Example:**
```php
use Event\Event;
use Event\EventManager;

$listener1 = function($var) {
    echo "Hi, {$var}.</br>";
};

$listener2 = function() {
    echo "How are you?";
};

$eventManager = new EventManager;
$event = new Event('acquaintance');

// Listen this event with priority
$eventManager->attach('acquaintance', $listener2, 1);
$eventManager->attach('acquaintance', $listener1, 2);

/**
 * Call event
 * 
 * output:
 * Hi, John.
 * How are you?
 */
$eventManager->trigger($event, null, ["John"]);
/**
 * Or $eventManager->trigger('acquaintance', null, ["Cate"]);
 */
```

**License: [MIT](https://github.com/Folleah/psr7-event-emitter/blob/master/README.md)**