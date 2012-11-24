<?php
namespace My\Adapter;

use DataGrid\Adapter\AbstractAdapter;

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
}