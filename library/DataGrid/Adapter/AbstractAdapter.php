<?php
namespace DataGrid\Adapter;

use DataGrid as Grid;

abstract class AbstractAdapter implements AdapterInterface, Grid\DataGridAwareInterface
{
    protected $adaptable;

    protected $dataGrid;

    protected $data;

    public function __construct($adaptable)
    {
        $this->adaptable = $adaptable;
    }

    final public function setDataGrid(Grid\DataGrid $dataGrid)
    {
        $this->dataGrid = $dataGrid;
    }

    public function getAdaptable()
    {
        return $this->adaptable;
    }

    public function toArray()
    {
        $this->fetchData();
        return $this->data;
    }
}