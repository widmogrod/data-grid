<?php
/**
 * @author gabriel
 */

namespace DataGrid\Adapter;

use DataGrid\DataGrid;

interface AdapterInterface
{
    public function __construct($adaptable);

    public function getAdaptable();

    public function fetchData();

    public function getTotalRecordsNumber();

    /**
     * Get columns info
     *
     * @return \DataGrid\Adapter\ColumnInfo\ColumnInfoInterface[]
     */
    public function getColumnsInfo();

    public function toArray();
}