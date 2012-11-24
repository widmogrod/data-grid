<?php
namespace DataGrid\StateStorage;

class Get extends AbstractStateStorage
{
    public function __construct($namespace = null) {
        $this->container = & $_GET;
    }
}