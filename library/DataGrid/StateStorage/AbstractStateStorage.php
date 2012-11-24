<?php
namespace DataGrid\StateStorage;

abstract class AbstractStateStorage implements StateStorageInterface
{
    protected $container = array();

    public function set($key, $value)
    {
        $this->container[$key] = $value;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->container);
    }

    public function merge($key, array $value)
    {
        if ($this->has($key)) {
            $baseValue = (array) $this->get($key);
            $value = array_merge($baseValue, $value);
            $this->set($key, $value);
        }

        $this->set($key, $value);
    }

    public function get($key, $default = null)
    {
        return $this->has($key)
            ? $this->container[$key]
            : $default;
    }

    public function setPageNumber($number)
    {
        $this->set('pageNumber', (int) $number);
    }

    public function getPageNumber()
    {
        return $this->get('pageNumber');
    }

    public function setItemsPerPage($number)
    {
        $this->set('itemsPerPage', (int) $number);
    }

    public function getItemsPerPage()
    {
        return $this->get('itemsPerPage');
    }

    public function setColumnAction($columnName, $action, $value)
    {
        $this->merge('actions', array($columnName => array($action => $value)));
    }

    public function getColumnActions($columnName, $default = array())
    {
        $actions = $this->get('actions', array());

        return isset($actions[$columnName])
            ? $actions[$columnName]
            : array();
    }

    public function getArrayCopy()
    {
        $this->container;
    }

    public function exchangeArray(array $array)
    {
        $this->container = $array;
    }


}