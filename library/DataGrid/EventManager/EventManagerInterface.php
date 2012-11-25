<?php
namespace DataGrid\EventManager;

interface EventManagerInterface
{
    /**
     * Trigger event
     *
     * @param EventInterface $event
     * @return Result\ResultInterface
     */
    public function trigger(EventInterface $event);

    /**
     * Attache event(s) to event manager
     *
     * @param string|ListenerInterface $listenerOrEvent
     * @param null|callable $listenerOrCallback
     */
    public function attach($listenerOrEvent, $listenerOrCallback = null);
}