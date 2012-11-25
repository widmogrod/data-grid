<?php
namespace My\Adapter;

use DataGrid\Adapter\AbstractAdapter;
use DataGrid\EventManager\AdapterEvent;

class Mock extends AbstractAdapter
{
    public function fetchData()
    {
        if (null === $this->data) {
            $this->data = $this->getAdaptable();
        }
    }

    public function getTotalRecordsNumber()
    {
        $this->fetchData();
        return count($this->data);
    }

    public function getColumnsInfo()
    {
        return array();
    }

    /**
     * Allow adapter to handle a change of state of a column actions.
     *
     * @param \DataGrid\EventManager\AdapterEvent $e
     * @return void
     */
    public function onAction(AdapterEvent $e)
    {

    }
}