<?php
/**
 * @author gabriel
 */

namespace DataGrid\Adapter;

use DataGrid\DataGrid;

interface AdapterInterface
{
    public function __construct($adaptable);

    /**
     * Get adaptable object|resource|type
     *
     * @return mixed
     */
    public function getAdaptable();

    /**
     * Fetch data from adaptable object|resource|type
     *
     * @return void
     */
    public function fetchData();

    /**
     * Get total records number
     *
     * @return int
     */
    public function getTotalRecordsNumber();

    /**
     * Get columns info
     *
     * @return \DataGrid\Adapter\ColumnInfo\ColumnInfoInterface[]
     */
    public function getColumnsInfo();

    /**
     * Return fetched data from adaptable object|resource|type as array
     *
     * @return array
     */
    public function toArray();
}