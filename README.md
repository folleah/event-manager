## PSR-7 Events implementation

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
    echo 'Hi, {$var}.<\br>';
};

$listener2 = function() {
    echo 'How are you?';
};

$eventManager = new EventManager;
$event = new Event('acquaintance');

// Listen this event with priority
$eventManager->attach($event->getName(), $listener2, 1);
$eventManager->attach($event->getName(), $listener1, 2);
/**
 * Or $eventManager->attach('acquaintance', $listener2, 1);
 */

// Call event
$eventManager->trigger($event->getName());
/**
 * Or $eventManager->trigger('acquaintance');
 */
```

**License: [MIT](https://github.com/Folleah/psr7-event-emitter/blob/master/README.md)**