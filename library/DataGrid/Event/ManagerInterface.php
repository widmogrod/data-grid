<?php
namespace DataGrid\Event;

interface ListenerInterface
{
    public function attach(ManagerInterface $manager);
}