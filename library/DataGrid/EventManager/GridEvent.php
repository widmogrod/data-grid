<?php
namespace DataGrid\EventManager;

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
     * Params
     *
     * @var array
     */
    protected $params = array();

    /**
     * Stop propagation...
     *
     * @var boolean
     */
    protected $stopPropagation;

    /**
     * Ensure to construct object with required params.
     *
     * @param string $name
     * @param \DataGrid\DataGrid $dataGrid
     */
    public function __construct($name, DataGrid $dataGrid)
    {
        $this->name = (string) $name;
        $this->setParam('grid', $dataGrid);
    }

    /**
     * Return data grid
     *
     * @return DataGrid
     */
    public function getDataGrid()
    {
        return $this->getParam('grid');
    }

    /**
     * Get event name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set stop propagation $flag
     *
     * @param boolean $flag
     * @return void
     */
    public function stopPropagation($flag)
    {
        $this->stopPropagation = (bool) $flag;
    }

    /**
     * Check is event is stopped
     *
     * @return bool
     */
    public function isStopped()
    {
        return $this->stopPropagation;
    }

    /**
     * Set param
     *
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * Get param
     *
     * @param string $name
     * @return mixed
     */
    public function getParam($name)
    {
        return array_key_exists($name, $this->params)
            ? $this->params[$name]
            : null;
    }

    /**
     * Return array of params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}