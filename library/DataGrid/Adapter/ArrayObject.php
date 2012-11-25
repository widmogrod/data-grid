<?php
namespace DataGrid\Adapter;

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
}