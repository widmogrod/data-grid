<?php
namespace DataGrid\Adapter;

use DataGrid\EventManager\AdapterEvent;

class ArrayObject extends AbstractAdapter
{
    /**
     * Fetch data from adaptable object|resource|type
     *
     * @return void
     */
    public function fetchData()
    {
        if (null === $this->data) {
            $adaptable = $this->getAdaptable();
            if ($adaptable instanceof \ArrayObject) {
                $this->data = $adaptable->getArrayCopy();
            } else {
                $this->data = (array) $adaptable;
            }

            $page = $this->getPageNumber() - 1;
            $limit = $this->getItemsPerPage();
            $this->data = array_splice($this->data, $page * $limit, $limit);
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
            $rowset = $this->getAdaptable();
            if ($rowset)
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

    /**
     * Get total records number
     *
     * @return int
     */
    public function getTotalRecordsNumber()
    {
        if (null === $this->totalRecord)
        {
            $adaptable = $this->getAdaptable();
            $this->totalRecord = count($adaptable);
        }

        return $this->totalRecord;
    }

    /**
     * Allow adapter to handle a change of state of a column actions.
     *
     * @param \DataGrid\EventManager\AdapterEvent $e
     * @return void
     */
    public function onAction(AdapterEvent $e)
    {
        if ($e->getAdapter() !== $this) {
            return;
        }

        $columnName = $e->getColumn()->getName();

        switch ($e->getAction())
        {
            case 'order':
                $adaptable = $e->getAdapter()->getAdaptable();

                $orderColumn = array();
                foreach ($adaptable as $key => $value) {
                    $orderColumn[$key] = $value[$columnName];
                }
                $order = ($e->getValue() != 'asc') ? SORT_DESC : SORT_ASC;
                array_multisort($orderColumn, $order, $adaptable);

                // update adaptable array
                $this->adaptable = $adaptable;
                break;
        }
    }
}