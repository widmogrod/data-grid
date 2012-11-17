<?php
namespace DataGrid;

interface RendererInterface
{
    public function setDataGrid(DataGrid $dataGrid);

    public function render();
}