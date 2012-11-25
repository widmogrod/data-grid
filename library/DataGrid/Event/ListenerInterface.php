<?php
namespace DataGrid\Event;

interface ListenerInterface
{
    /**
     * Attache events to event manager
     *
     * @param ManagerInterface $manager
     * @return void
     */
    public function attach(ManagerInterface $manager);
}