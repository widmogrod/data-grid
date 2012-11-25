<?php
namespace DataGrid\Adapter;

use DataGrid as Grid;
use DataGrid\Event\ManagerInterface;
use DataGrid\Event\ListenerInterface;
use DataGrid\Event\EventInterface;
use DataGrid\Event\GridEvent;

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
    protected $itemsPerPage;

    /**
     * Page number
     *
     * @var integer
     */
    protected $pageNumber;

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
     * Attache events to event manager
     *
     * @param ManagerInterface $manager
     * @return void
     */
    public function attach(ManagerInterface $manager)
    {
        $manager->attach(GridEvent::EVENT_EXECUTE, array($this, 'onExecute'), 10);
        $manager->attach(GridEvent::EVENT_EXECUTE, array($this, 'onExecute'), -10);
    }

    public function onExecute(EventInterface $e)
    {
        $stateStorage = $e->getDataGrid()->getStateStorage();

        $this->setItemsPerPage($stateStorage->getItemsPerPage());
        $this->setPageNumber($stateStorage->getPageNumber());

        foreach ($this->getColumnsInfo() as $column) {
            $actions = $stateStorage->getColumnActions($column->getName());
            $this->triggerActionOnColumn($column->getName(), $actions);
        }
    }

    /**
     * Set items per page
     *
     * @param int $itemsPerPage
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
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
        $this->pageNumber = $pageNumber;
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
}