<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin\Table;


use ArrayIterator;
use IteratorAggregate;

class Row implements IteratorAggregate
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

}