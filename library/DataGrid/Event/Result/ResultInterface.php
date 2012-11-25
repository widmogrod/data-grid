<?php
namespace DataGrid\Event\Result;

interface ResultInterface extends \Iterator, \Countable
{
    /**
     * Return first element in queue
     *
     * @return mixed
     */
    public function first();

    /**
     * Return last element in queue
     * @return mixed
     */
    public function last();

    /**
     * Append element in queue
     *
     * @param mixed $value
     * @return mixed
     */
    public function append($value);
}