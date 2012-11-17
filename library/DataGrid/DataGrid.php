<?php
/**
 * @author gabriel
 */

namespace DataGrid;

class DataGrid
{
    /**
     * Types of data elements
     */
    const CELL = 'cell';
    const COLUMN = 'column';

    /**
     * Provided data adapter
     *
     * @var Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * Rendering strategy
     *
     * @var Renderer\RendererInterface
     */
    protected $renderer;

    /**
     * List of shipped with DataGrid data adapters
     *
     * @var array
     */
    protected $invokableAdapters = array(
        'doctrine' => 'DataGrid\Adapter\Doctrine',
    );

    /**
     * List of data types that will be wrapped by predefined adapter
     *
     * @var array
     */
    protected $dataTypeToAdapter = array(
        'Doctrine\ORM\NativeQuery' => 'doctrine',
        'Doctrine\ORM\Query' => 'doctrine',
    );

    protected $specialColumns = array();

    public function __construct($dataOrAdapter = null, array $options = null)
    {
        if (null !== $dataOrAdapter) {
            $this->setAdapter($dataOrAdapter);
        }
        if (null !== $options) {
            $this->setOptions($options);
        }
    }

    protected function setOptions($options)
    {
        $methodWithAddPrefix = array(
            'invokableAdapters' => true,
            'dataTypeToAdapter' => true,
        );
        foreach($options as $key => $value) {
            $prefix =  isset($methodWithAddPrefix[$key]) ? 'add' : 'set';
            $method = $prefix . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function addInvokableAdapters(array $adapters) {
        $this->invokableAdapters = array_merge(
            $this->invokableAdapters,
            $adapters
        );
    }

    public function addDataTypesToAdapter(array $dataTypesToAdapter) {
        $this->dataTypeToAdapter = array_merge(
            $this->dataTypeToAdapter,
            $dataTypesToAdapter
        );
    }

    public function setAdapter($dataOrAdapter)
    {
        if (!($dataOrAdapter instanceof Adapter\AdapterInterface))
        {
            $dataType = is_object($dataOrAdapter)
                ? get_class($dataOrAdapter)
                : gettype($dataOrAdapter);

            if (!isset($this->dataTypeToAdapter[$dataType])) {
                $message = 'Given data is not instance of "DataGrid\Adapter\AdapterInterface" ' .
                           'and data type "%s" can\'t be wrapped by existing adapters (%s)';
                $message = sprintf(
                    $message,
                    implode(', ', array_map(function($key, $value){
                        return "$key => $value";
                    }, array_keys($this->dataTypeToAdapter), $this->dataTypeToAdapter))
                );
                throw new Exception\InvalidArgumentException($message);
            }

            $adapterAlias = $this->dataTypeToAdapter[$dataType];
            if (!isset($this->invokableAdapters[$adapterAlias])) {
                $message = 'Given adapter alias "%s" for data type "%s" ' .
                           'can\'t be wrapped by known adapters (%s)';
                $message = sprintf(
                    $message,
                    $adapterAlias,
                    $dataType,
                    implode(', ', array_map(function($key, $value){
                        return "$key => $value";
                    }, array_keys($this->invokableAdapters), $this->invokableAdapters))
                );
                throw new Exception\InvalidArgumentException($message);
            }

            $dataOrAdapter = new $this->invokableAdapters[$adapterAlias]($dataOrAdapter);
        }

        if ($dataOrAdapter instanceof DataGridAwareInterface) {
            $dataOrAdapter->setDataGrid($this);
        }

        $this->adapter = $dataOrAdapter;
    }

    public function getAdapter()
    {
        if (null !== $this->adapter) {
            return $this->adapter;
        }

        $message = 'Adapter is not set';
        throw new Exception\InvalidArgumentException($message);
    }

    public function setRenderer(Renderer\RendererInterface $renderer)
    {
        $renderer->setDataGrid($this);
        $this->renderer = $renderer;
    }

    public function getRenderer()
    {
        if (null !== $this->renderer) {
            return $this->renderer;
        }

        $message = 'Renderer is not set';
        throw new Exception\InvalidArgumentException($message);
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

        if (is_array($columnOptions))
        {
            $baseOptions = array_merge($baseOptions, $columnOptions);
        }
        elseif ($columnOptions instanceof \Closure)
        {
            $baseOptions[self::CELL] = $columnOptions;
        }

        $this->specialColumns[$columnName] = $baseOptions;
    }

    public function setSpecialColumns(array $specialColumns)
    {
        $this->specialColumns = array();
        foreach ($specialColumns as $name => $options) {
            $this->setSpecialColumn($name, $options);
        }
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
                $message = sprintf('Undefined type "%s"', $type);
                throw new Exception\InvalidArgumentException($message);
        }
    }
}
