<?php
namespace DataGrid\Adapter;

use DataGrid as Grid;
use DataGrid\EventManager\EventManagerInterface;
use DataGrid\EventManager\ListenerInterface;
use DataGrid\EventManager\AdapterEvent;
use DataGrid\EventManager\GridEvent;

abstract class AbstractAdapter
    implements AdapterInterface, Grid\DataGridAwareInterface, ListenerInterface
{
    /**
     * Adaptable data
     *
     * @var mixed
     */
    protected $adaptable;

    /**
     * Data grid object
     *
     * @var Grid\DataGrid
     */
    protected $dataGrid;

    /**
     * Adapted data
     *
     * @var array
     */
    protected $data;

    /**
     * Items per page
     *
     * @var integer
     */
    protected $itemsPerPage = 10;

    /**
     * Page number
     *
     * @var integer
     */
    protected $pageNumber = 1;

    /**
     * Columns info
     *
     * @var \DataGrid\Adapter\ColumnInfo\ColumnInfoInterface[]
     */
    protected $columnInfo;

    /**
     * Total records number
     *
     * @var int
     */
    protected $totalRecord;

    public function __construct($adaptable)
    {
        $this->adaptable = $adaptable;
    }

    final public function setDataGrid(Grid\DataGrid $dataGrid)
    {
        $this->dataGrid = $dataGrid;
    }

    /**
     * Get adaptable object|resource|type
     *
     * @return mixed
     */
    public function getAdaptable()
    {
        return $this->adaptable;
    }

    /**
     * Return fetched data from adaptable object|resource|type as array
     *
     * @return array
     */
    public function toArray()
    {
        $this->fetchData();
        return $this->data;
    }

    /**
     * Set items per page
     *
     * @param int $itemsPerPage
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = ($itemsPerPage > 0) ? $itemsPerPage : 10;
    }

    /**
     * Get items per page
     *
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * Set page number
     *
     * @param int $pageNumber
     */
    public function setPageNumber($pageNumber)
    {
        $this->pageNumber = ($pageNumber > 0) ? $pageNumber : 1;
    }

    /**
     * Get page number
     *
     * @return int
     */
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    /**
     * Attache events to event manager
     *
     * @param EventManagerInterface $manager
     * @return void
     */
    public function attach(EventManagerInterface $manager)
    {
        $manager->attach(GridEvent::EVENT_EXECUTE, array($this, 'onExecute'), 10);
        $manager->attach(AdapterEvent::EVENT_ACTION, array($this, 'onAction'), -1000);
    }

    /**
     * Prepare adapter
     *
     * @param \DataGrid\EventManager\GridEvent $e
     */
    public function onExecute(GridEvent $e)
    {
        $eventManager = $e->getDataGrid()->getEventManager();
        $stateStorage = $e->getDataGrid()->getStateStorage();

        $this->setItemsPerPage($stateStorage->getItemsPerPage());
        $this->setPageNumber($stateStorage->getPageNumber());

        foreach ($this->getColumnsInfo() as $column) {
            $actions = $stateStorage->getColumnActions($column->getName());
            foreach ($actions as $action => $value) {
                // prepare event
                $e = new AdapterEvent();
                $e->setColumn($column);
                $e->setAction($action);
                $e->setValue($value);
                $e->setAdapter($this);
                // trigger
                $eventManager->trigger($e);
            }
        }
    }

    /**
     * Allow adapter to handle a change of state of a column actions.
     *
     * @param \DataGrid\EventManager\AdapterEvent $e
     * @return void
     */
    abstract public function onAction(AdapterEvent $e);
}