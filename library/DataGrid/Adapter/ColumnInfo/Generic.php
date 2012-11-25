<?php
namespace DataGrid\Adapter\ColumnInfo;

class Generic implements ColumnInfoInterface
{
    protected $name;
    protected $type;

    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }
    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }
}