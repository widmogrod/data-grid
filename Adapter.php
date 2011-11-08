<?php
/**
 * @author gabriel
 */

namespace DataGrid;

interface Adapter
{
    public function __construct($adaptable);

    public function setDataGrid(DataGrid $dataGrid);

    public function getAdaptable();

    public function fetchData();

    public function getTotalRecord();

    public function getColumnsInfo();

    public function toArray();
}