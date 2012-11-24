<?php
namespace DataGrid\Event;

use DataGrid\DataGrid;

class Event implements EventInterface
{
    /**
     * Event name
     *
     * @var string
     */
    protected $name;

    /**
     * Data grid object
     *
     * @var \DataGrid\DataGrid
     */
    protected $dataGrid;

    /**
     * Stop propagation...
     *
     * @var boolean
     */
    protected $stopPropagation;

    public function __construct($name, DataGrid $dataGrid)
    {
        $this->name = (string) $name;
        $this->dataGrid = $dataGrid;
    }

    public function getDataGrid()
    {
        return $this->dataGrid;
    }

    public function getName()
    {
        return $this->name;
    }

    public function stopPropagation($flag)
    {
        $this->stopPropagation = (bool) $flag;
    }

    public function isStopped()
    {
        return $this->stopPropagation;
    }


}