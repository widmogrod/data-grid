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

    public function getColumnsInfo();

    public function toArray();
}