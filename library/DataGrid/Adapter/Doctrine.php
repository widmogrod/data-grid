<?php
namespace DataGrid\Adapter;

class Doctrine extends AbstractAdapter
{
    protected $totalRecord;

    protected $columnInfo;

    public function fetchData()
    {
        if (null === $this->data)
        {
            /* @var $adaptable \Doctrine\ORM\Query */
            $adaptable = $this->getAdaptable();
            $this->data = $adaptable->getScalarResult();
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

//            /* @var $adaptable \Doctrine\ORM\Query */
//            $adaptable = $this->getAdaptable();
//            /* @var $em \Doctrine\ORM\EntityManager */
//            $em = $adaptable->getEntityManager();
//            /* @var $ast Doctrine\ORM\Query\AST\SelectStatement */
//            $ast = $adaptable->getAST();
        }

        return $this->columnInfo;
    }

    public function getTotalRecord()
    {
        if (null === $this->totalRecord)
        {
            /* @var $adaptable \Doctrine\ORM\Query */
            $adaptable = $this->getAdaptable();
            $this->totalRecord = $adaptable;
        }

        return $this->totalRecord;
    }
}