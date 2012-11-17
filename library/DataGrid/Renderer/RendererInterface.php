<?php
namespace DataGrid\Renderer;

use DataGrid\DataGrid;

interface RendererInterface
{
    public function setDataGrid(DataGrid $dataGrid);

    public function render();
}