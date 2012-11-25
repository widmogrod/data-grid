<?php
namespace DataGrid\EventManager;

use DataGrid\Exception;
use SplPriorityQueue as PriorityQueue;

class EventManager implements EventManagerInterface
{
    /**
     * Collection of listeners
     *
     * @var PriorityQueue[]
     */
    protected $listeners = array();

    /**
     * Trigger event
     *
     * @param EventInterface $event
     * @return Result\ResultInterface
     */
    public function trigger(EventInterface $event)
    {
        $results = new Result\Standard();
        $eventName = $event->getName();
        foreach ($this->getEventListeners($eventName) as $listener)
        {
            if ($listener instanceof \Closure) {
                $result = $listener($event);
            } else {
                $result = call_user_func($listener, $event);
            }

            $results->append($result);

            if ($event->isStopped()) {
                break;
            }
        }

        return $results;
    }

    /**
     * Attache event(s) to event manager
     *
     * @param string|ListenerInterface $listenerOrEvent
     * @param null|callable $listenerOrCallback
     */
    public function attach($listenerOrEvent, $listenerOrCallback = null, $priority = null)
    {
        if ($listenerOrEvent instanceof ListenerInterface) {
            $listenerOrEvent->attach($this);
        } else if (is_string($listenerOrEvent) && is_callable($listenerOrCallback)) {
            $this->addEventListener($listenerOrEvent, $listenerOrCallback, $priority);
        } else {
            $type = is_object($listenerOrEvent)
                ? get_class($listenerOrEvent)
                : gettype($listenerOrEvent);

            $message = 'Event is not set or listener is not instance of "DataGrid\EventManager\ListenerInterface" or is not callable. ';
            $message .= 'Listener type given: %s';
            $message = sprintf($message, $type);

            throw new Exception\InvalidArgumentException($message);
        }
    }

    public function detach()
    {

    }

    protected function addEventListener($eventName, $callback, $priority)
    {
        if (!isset($this->listeners[$eventName])) {
            $this->listeners[$eventName] = new PriorityQueue();
        }
        $priority = is_integer($priority) ? $priority : 1;
        $this->listeners[$eventName]->insert($callback, $priority);
    }

    protected function getEventListeners($eventName)
    {
        return isset($this->listeners[$eventName])
            ? $this->listeners[$eventName]
            : new PriorityQueue();
    }
}