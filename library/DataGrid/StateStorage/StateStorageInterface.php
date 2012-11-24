<?php
namespace DataGrid\StateStorage;

interface StateStorageInterface
{
    public function setPageNumber($number);
    public function getPageNumber();

    public function setItemsPerPage($number);
    public function getItemsPerPage();

    public function setColumnAction($columnName, $action, $value);
    public function getColumnActions($columnName);

    public function getArrayCopy();
    public function exchangeArray(array $array);
}