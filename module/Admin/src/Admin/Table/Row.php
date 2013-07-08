<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin\Table;


use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

class Row implements IteratorAggregate, ArrayAccess
{

    /**
     * @var array
     */
    protected $columns = array();

    /**
     * @param array $columns
     */
    public function __construct(array $columns)
    {
        $values = array_fill(0, count($columns), '');
        $this->columns = array_combine($columns, $values);
    }

    /**
     * @param string $column
     * @param string $value
     */
    public function setValue($column, $value)
    {
        if (isset($this->columns[$column])) {
            $this->columns[$column] = $value;
        }
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return array_keys($this->columns);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->columns);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->columns);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->columns[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if ($this->offsetExists($offset)) {
            $this->columns[$offset] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->columns[$offset] = "";
    }
}