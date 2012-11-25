<?php 
namespace DataGrid\Renderer;

use DataGrid as Grid;
use DataGrid\EventManager\ListenerInterface;
use DataGrid\EventManager\EventManagerInterface;
use DataGrid\EventManager\EventInterface;
use DataGrid\EventManager\GridEvent;

class HtmlTable implements RendererInterface, Grid\DataGridAwareInterface, ListenerInterface
{
    /**
     * Data grid object
     *
     * @var Grid\DataGrid
     */
    protected $dataGrid;

    /**
     * Column names
     *
     * @var string[]
     */
    protected $columnsNames = array();

    public function setDataGrid(Grid\DataGrid $dataGrid)
    {
        $this->dataGrid = $dataGrid;
    }

    public function attach(EventManagerInterface $manager)
    {
        $manager->attach(GridEvent::EVENT_RENDER, array($this, 'onRender'), -100);
    }

    public function render()
    {
        $tableClass = 'table zebra-striped';
        $head = $this->renderHead();
        $body = $this->renderBody();
        $foot = $this->renderFoot();
        return sprintf('<table class="%s">%s %s %s</table>', $tableClass, $head, $body, $foot);
    }

    public function onRender(EventInterface $e = null)
    {
        $e->stopPropagation(true);
        return $this->render();
    }

    private function getColumnNames()
    {
        if (array() === $this->columnsNames)
        {
            $this->columnsNames = array();
            $columns = $this->dataGrid->getAdapter()->getColumnsInfo();
            foreach ($columns as $column) {
                $this->columnsNames[] = $column->getName();
            }
        }
        return $this->columnsNames;
    }

    private function renderHead()
    {
        $columns = $this->dataGrid->getAdapter()->getColumnsInfo();
        $specialCells = $this->renderSpecialColumns($columns);

        $rows = array();
        foreach ($columns as $column) {
            $name = $column->getName();
            $rows[$name] = $name;
        }

        $rows = array_merge($rows, $specialCells);
        $rows = array_map(array($this, 'renderHeadCell'), $rows);
        $rows = implode("\n", $rows);

        return sprintf('<tr>%s</tr>', $rows);
    }

    private function renderBody()
    {
        $rowset = $this->dataGrid->getAdapter()->toArray();
        $columnNames = $this->getColumnNames();

        $rows = array();
        while($row = array_shift($rowset))
        {
            // create table with aliases
            // this allow array_merge with named spacial columns
            // to merge completely... ie. special column can swap with row cell.
            $row = array_combine($columnNames, $row);
            $specialCells = $this->renderSpecialCell($row);
            $row = array_merge($row, $specialCells);
            $cells = sprintf('<td>%s</td>', implode('</td><td>', $row));
            $rows[] = sprintf('<tr>%s</tr>', $cells);
        }

        return implode("\n", $rows);
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