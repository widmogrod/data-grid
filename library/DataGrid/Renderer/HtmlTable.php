<?php 
namespace DataGrid\Renderer;

use DataGrid as Grid;

class HtmlTable implements RendererInterface, Grid\DataGridAwareInterface
{
    /**
     * @var Grid\DataGrid
     */
    protected $dataGrid;

    protected $columnsNames;

    public function setDataGrid(Grid\DataGrid $dataGrid)
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
        $columnName = $this->getColumnNames();

        $rows = array();
        while($row = array_shift($rowset))
        {
            // create table with aliases
            // this allow array_merge with named spacial columns
            // to merge commplitly... ie. special column can swap with row cell.
            $row = array_combine($columnName, $row);
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
            $name = $column['name'];
            $rows[$name] = $column['name'];
        }

        $rows = array_merge($rows, $specialCells);
        $rows = array_map(array($this, 'renderHeadCell'), $rows);
        $rows = implode("\n", $rows);

        return sprintf('<tr>%s</tr>', $rows);
    }

    private function getColumnNames()
    {
        if (null === $this->columnsNames)
        {
            $columns = $this->dataGrid->getAdapter()->getColumnsInfo();

            $this->columnsNames = array();
            while($column = array_shift($columns)) {
                $this->columnsNames[] = $column['name'];
            }
        }

        return $this->columnsNames;
    }

    private function renderFoot()
    {
        // TODO
    }

    private function renderSpecialCell(array $row)
    {
        $result = array();

        $specialCells = $this->dataGrid->getSpecialColumnsByType(Grid\DataGrid::CELL);
        foreach($specialCells as $name => $cell)
        {
            if ($cell instanceof \Closure)
            {
                $result[$name] = $cell($row);
            }
            else
            {
                $result[$name] = (string) $cell;
            }
        }

        return $result;
    }

    private function renderSpecialColumns(array $data)
    {
        $result = array();

        $specialColumns = $this->dataGrid->getSpecialColumnsByType(Grid\DataGrid::COLUMN);
        foreach($specialColumns as $name => $column)
        {
            if ($column instanceof \Closure)
            {
                $result[$name] = $column($data);
            }
            else
            {
                $result[$name] = $column;
            }
        }

        return $result;
    }

    private function renderAttribs(array $attribs)
    {
        $result = '';
        foreach($attribs as $key => $value)
        {
            $value = (string) $value;
            // $value = addslashes((string) $value);
            $result .= sprintf(' %s="%s"', $key, (string) $value);
        }

        return $result;
    }

    private function renderHeadCell($data)
    {
        $attribs = array();
        $name = null;

        if (is_array($data))
        {
            $attribs = isset($data['attribs']) ? $data['attribs'] : array();
            $name    = isset($data['name']) ? $data['name'] : '';
        }
        else
        {
            $name = (string) $data;
        }

        return sprintf('<th%s>%s</th>', $this->renderAttribs($attribs), $name);
    }
}