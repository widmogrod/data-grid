<?php
namespace DataGrid\Event;

use DataGrid\DataGrid;

class GridEvent implements EventInterface
{
    /**#@+
     * Event types
     *
     * @var string
     */
    const EVENT_RENDER = 'render';
    const EVENT_EXECUTE = 'execute';
    const EVENT_RENDERER_SET = 'renderer_set';
    const EVENT_ADAPTER_SET = 'adapter_set';
    const EVENT_STATE_STORAGE_SET = 'state_storage_set';
    /**#@+*/

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