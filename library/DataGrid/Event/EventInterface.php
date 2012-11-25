<?php
namespace DataGrid\Event;

use DataGrid\DataGrid;

interface EventInterface
{
    /**
     * Get event name
     *
     * @return string
     */
    public function getName();

    /**
     * Set stop propagation $flag
     *
     * @param boolean $flag
     * @return void
     */
    public function stopPropagation($flag);

    /**
     * Check is event is stopped
     *
     * @return bool
     */
    public function isStopped();

    /**
     * Set param
     *
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function setParam($name, $value);

    /**
     * Get param
     *
     * @param string $name
     * @return mixed
     */
    public function getParam($name);

    /**
     * Return array of params
     *
     * @return array
     */
    public function getParams();
}