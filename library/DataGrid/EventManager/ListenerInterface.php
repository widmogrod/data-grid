<?php
namespace DataGrid\EventManager;

interface ListenerInterface
{
    /**
     * Attache events to event manager
     *
     * @param EventManagerInterface $manager
     * @return void
     */
    public function attach(EventManagerInterface $manager);
}