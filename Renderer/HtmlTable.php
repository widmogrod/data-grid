<?php
/**
 * @author gabriel
 */
 
namespace DataGrid\Renderer;

use DataGrid\Renderer;
use DataGrid\DataGrid;

class HtmlTable implements Renderer
{
    /**
     * @var \DataGrid\DataGrid
     */
    protected $dataGrid;

    public function setDataGrid(DataGrid $dataGrid)
    {
        $this->dataGrid = $dataGrid;
    }

    public function render()
    {
        $tableClass = 'zebra-striped';
        $head = $this->renderHead();
        $body = $this->renderBody();
        $foot = $this->renderFoot();
        return sprintf('<table class="%s">%s %s %s</table>', $tableClass, $head, $body, $foot);
    }

    private function renderBody()
    {
        $rowset = $this->dataGrid->getAdapter()->toArray();

        $rows = array();
        while($row = array_shift($rowset))
        {
            $specialCells = $this->renderSpecialCell($row);
            $row = array_merge($row, $specialCells);
            $cells = sprintf('<td>%s</td>', implode('</td><td>', $row));
            $rows[] = sprintf('<tr>%s</tr>', $cells);
        }

        return implode("\n", $rows);
    }

    private function renderHead()
    {
        $columns = $this->dataGrid->getAdapter()->getColumnsInfo();
        $specialCells = $this->renderSpecialColumns($columns);

        $rows = array();
        while($column = array_shift($columns)) {
            $rows[] = $column['name'];
        }
        $rows = array_merge($rows, $specialCells);
        $rows = sprintf('<th>%s</th>', implode('</th><th>', $rows));
        return sprintf('<tr>%s</tr>', $rows);
    }

    private function renderFoot()
    {
        // TODO
    }

    private function renderSpecialCell(array $row)
    {
        $result = array();

        $specialCells = $this->dataGrid->getSpecialColumnsByType(DataGrid::CELL);
        foreach($specialCells as $cell)
        {
            if ($cell instanceof \Closure)
            {
                $result[] = $cell($row);
            }
            else
            {
                $result[] = (string) $cell;
            }
        }

        return $result;
    }

    private function renderSpecialColumns(array $data)
    {
        $result = array();

        $specialColumns = $this->dataGrid->getSpecialColumnsByType(DataGrid::COLUMN);
        foreach($specialColumns as $column)
        {
            if ($column instanceof \Closure)
            {
                $result[] = $column($data);
            }
            else
            {
                $result[] = (string) $column;
            }
        }

        return $result;
    }
}