<?php
namespace DataGrid\Event;

use DataGrid\DataGrid;

interface EventInterface
{
    /**
     * Get data grid object
     *
     * @return DataGrid
     */
    public function getDataGrid();

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
}