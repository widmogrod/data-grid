<?php
namespace DataGrid\EventManager\Result;

class Standard implements ResultInterface
{
    /**
     * Collection of data to iterate
     *
     * @var array
     */
    protected $data = array();

    /**
     * Position of iteration.
     *
     * @var int
     */
    protected $position = 0;

    /**
     * Number of items in iterator.
     *
     * @var int
     */
    protected $count = 0;

    public function current()
    {
        return array_key_exists($this->position, $this->data)
            ? $this->data[$this->position]
            : null;
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return $this->position < $this->count;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Return first element in queue
     *
     * @return mixed
     */
    public function first()
    {
        $key = 0;
        return array_key_exists($key, $this->data)
            ? $this->data[$key]
            : null;
    }

    /**
     * Return last element in queue
     *
     * @return mixed
     */
    public function last()
    {
        $key = $this->count -1;
        return array_key_exists($key, $this->data)
            ? $this->data[$key]
            : null;
    }

    /**
     * Append element in queue
     *
     * @param mixed $value
     * @return mixed
     */
    public function append($value)
    {
        $this->data[] = $value;
        ++$this->count;
    }

    public function count()
    {
        return $this->count;
    }
}