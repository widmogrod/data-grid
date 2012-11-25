<?php
namespace DataGrid\Event;

use DataGrid\DataGrid;
use DataGrid\Adapter\ColumnInfo\ColumnInfoInterface;
use DataGrid\Adapter\AdapterInterface;

class AdapterEvent implements EventInterface
{
    /**#@+
     * Event types
     *
     * @var string
     */
    const EVENT_ACTION = 'action';
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
     * Construct event
     */
    public function __construct()
    {
        $this->name = (string) self::EVENT_ACTION;
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

    public function setAction($action)
    {
        $this->setParam('action', $action);
    }

    public function getAction()
    {
        return $this->getParam('action');
    }

    public function setValue($value)
    {
        $this->setParam('value', $value);
    }

    public function getValue()
    {
        return $this->getParam('value');
    }

    public function setAdapter(AdapterInterface $adaptable)
    {
        $this->setParam('adapter', $adaptable);
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->getParam('adapter');
    }

    public function setColumn(ColumnInfoInterface $column)
    {
        $this->setParam('column', $column);
    }

    /**
     * @return ColumnInfoInterface
     */
    public function getColumn()
    {
        return $this->getParam('column');
    }
}