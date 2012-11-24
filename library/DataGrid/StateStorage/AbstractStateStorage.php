<?php
namespace DataGrid\StateStorage;

abstract AbstractStateStorage implements StateStorageInterface
{
    protected $pageNumber;
    protected $itemsPerPage;
    protected $actions;

    public function setPageNumber($number)
    {
        $this->pageNumber = (int) $number;
    }

    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    public function setItemsPerPage($number)
    {
        $this->itemsPerPage = (int) $number;
    }

    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    public function setColumnAction($columnName, $action, $value)
    {
        if (!isset($this->actions[$columnName])) {
            $this->actions[$columnName] = array();
        }
        $this->actions[$columnName][$action] = $value;
    }

    public function getColumnActions($columnName, $default = array())
    {
        return isset($this->actions[$columnName])
            ? $this->actions[$columnName]
            : $default;
    }
}