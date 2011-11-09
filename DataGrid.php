<?php
/**
 * @author gabriel
 */

namespace DataGrid;

class DataGrid
{
    const CELL = 'cell';
    const COLUMN = 'column';

    /**
     * @var Adapter
     */
    protected $adapter;

    /**
     * @var Renderer
     */
    protected $renderer;

    /**
     * @var string
     */
    protected $baseUrl;

    protected $specialColumns = array();

    final public static function factory($data, $options = null)
    {
        switch(true)
        {
            case ($data instanceof \Doctrine\ORM\Query):
                $adapter = new \DataGrid\Adapter\Doctrine($data);
                break;

            default:
                throw new \InvalidArgumentException(sprintf('Data type "%s" is not suported', gettype($data)));
        }

        return new self($adapter, $options);
    }

    protected function __construct(Adapter $adapter, $options = null)
    {
        $adapter->setDataGrid($this);
        $this->adapter = $adapter;

        if (is_array($options) || $options instanceof \Traversable) {
            $this->setOptions($options);
        }
    }

    protected function setOptions($options)
    {
        foreach($options as $key => $value)
        {
            $key = trim($key);
            switch(strtolower($key))
            {
                case 'adapter':
                    throw new \InvalidArgumentException(sprintf('Option "%s" is reserwed keyword.', $key));
            }

            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    public function setRenderer(Renderer $renderer)
    {
        $renderer->setDataGrid($this);
        $this->renderer = $renderer;
    }

    public function getRenderer()
    {
        return $this->renderer;
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function toArray()
    {
        return $this->getAdapter()->toArray();
    }

    public function render()
    {
        return $this->getRenderer()->render();
    }

    public function setSpecialColumn($columnName, $columnOptions)
    {
        $baseOptions = array(
            self::CELL => null,
            self::COLUMN => null,
        );

        if ($columnOptions instanceof \Closure) {
            $baseOptions[self::CELL] = $columnOptions;
        }

        $this->specialColumns[$columnName] = $baseOptions;
    }

    public function setSpecialColumns(array $specialColumns)
    {
        $this->specialColumns = array();
        array_walk(array($this, 'setSpecialColumn'), $specialColumns);
    }

    public function getSpecialColumns()
    {
        return $this->specialColumns;
    }

    public function getSpecialColumnsByType($type)
    {
        switch($type)
        {
            case self::CELL:
                return array_map(function($item) {
                        return $item[DataGrid::CELL];
                }, $this->getSpecialColumns());

            case self::COLUMN:
                return array_map(function($item) {
                        return $item[DataGrid::COLUMN];
                }, $this->getSpecialColumns());

            default:
                throw new \InvalidArgumentException(sprintf('Undefined type "%s"', $type));
        }
    }
}
