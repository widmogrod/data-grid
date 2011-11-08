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
            $rows[] = sprintf('<tr><td>%s</td></tr>', implode('</td><td>', $row));
        }

        return implode("\n", $rows);
    }

    private function renderHead()
    {
        $columns = $this->dataGrid->getAdapter()->getColumnsInfo();

        $rows = array();
        while($column = array_shift($columns))
        {
            $rows[] = sprintf('<th>%s</th>', $column['name']);
        }
        return sprintf('<tr>%s</tr>', implode($rows));
    }

    private function renderFoot()
    {
    }
}