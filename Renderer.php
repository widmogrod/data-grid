<?php
/**
 * @author gabriel
 */
 
namespace DataGrid;

interface Renderer
{
    public function setDataGrid(DataGrid $dataGrid);

    public function render();
}