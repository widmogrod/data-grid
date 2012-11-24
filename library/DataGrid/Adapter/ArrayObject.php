<?php
namespace DataGrid\Adapter;

use DataGrid\Event\ManagerInterface;
use DataGrid\Event\ListenerInterface;

class ArrayObject extends AbstractAdapter implements ListenerInterface
{
    protected $totalRecord;

    protected $columnInfo;

    public function attach(ManagerInterface $manager)
    {
        $manager->attach('render', array($this, 'onRender'));
    }

    public function onRender(\DataGrid\Event\Event $e)
    {
        $state = $e->getDataGrid()->getStateStorage();
        $state->getItemsPerPage();
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

    public function getColumnsInfo()
    {
        if (null === $this->columnInfo)
        {
            $this->columnInfo = array();
            if ($rowset = $this->toArray())
            {
                $row = current($rowset);
                $row = array_keys($row);
                $this->columnInfo = array_map(function($column) {
                    return array(
                        'name' => $column
                    );
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