<?php
namespace DataGrid\Event;

interface EventInterface
{
    public function getDataGrid();

    public function getName();

    public function stopPropagation($flag);

    public function isStopped();
}