<?php
namespace DataGrid\Adapter;

use DataGrid\Event\ManagerInterface;
use DataGrid\Event\ListenerInterface;
use DataGrid\Event\EventInterface;
use DataGrid\Event\GridEvent;

class ArrayObject extends AbstractAdapter implements ListenerInterface
{
    protected $totalRecord;

    protected $columnInfo;

    public function attach(ManagerInterface $manager)
    {
        $manager->attach(GridEvent::EVENT_EXECUTE, array($this, 'onExecute'));
    }

    public function onExecute(EventInterface $e)
    {
        $stateStorage = $e->getDataGrid()->getStateStorage();

        $this->changeItemsPerPage($stateStorage->getItemsPerPage());
        $this->changePageNumber($stateStorage->getPageNumber());

        foreach ($this->getColumnsInfo() as $column) {
            $actions = $stateStorage->getColumnActions($column->getName());
            $this->triggerActionOnColumn($column->getName(), $actions);
        }
    }

    protected function changePageNumber($number)
    {

    }

    protected function changeItemsPerPage($number)
    {

    }

    protected function triggerActionOnColumn($column, array $actions) {

    }

    public function fetchData()
    {
        if (null === $this->data) {
            $adaptable = $this->getAdaptable();
            if ($adaptable instanceof \ArrayObject) {
                $this->data = $adaptable->getArrayCopy();
            } else {
                $this->data = (array) $adaptable;
            }
        }
    }

    /**
     * Get columns info
     *
     * @return \DataGrid\Adapter\ColumnInfo\ColumnInfoInterface[]
     */
    public function getColumnsInfo()
    {
        if (null === $this->columnInfo)
        {
            $this->columnInfo = array();
            if ($rowset = $this->toArray())
            {
                $row = current($rowset);
                $row = array_keys($row);
                $this->columnInfo = array_map(function($columnName) {
                    return new \DataGrid\Adapter\ColumnInfo\Generic($columnName, 'string');
                }, $row);
            }
        }

        return $this->columnInfo;
    }

    public function getTotalRecordsNumber()
    {
        if (null === $this->totalRecord)
        {
            $adaptable = $this->getAdaptable();
            $this->totalRecord = count($adaptable);
        }

        return $this->totalRecord;
    }
}