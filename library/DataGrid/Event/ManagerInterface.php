<?php
namespace DataGrid\Event;

interface ManagerInterface
{
    public function trigger(EventInterface $event);

    public function attach($listenerOrEvent, $listenerOrCallback = null);
}