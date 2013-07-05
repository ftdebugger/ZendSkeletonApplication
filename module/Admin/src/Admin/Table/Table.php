<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin\Table;


use Admin\Exception\RuntimeException;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Table implements IteratorAggregate, Countable
{

    /**
     * @var Row
     */
    protected $head;

    /**
     * @var Row[]
     */
    protected $rows;

    /**
     * Set value of Head
     *
     * @param Row $head
     * @return $this
     */
    public function setHead($head)
    {
        $this->head = $head;
        return $this;
    }

    /**
     * Return value of Head
     *
     * @return Row
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Return value of Rows
     *
     * @return Row[]
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param array $columns
     * @return Table
     */
    public function createHead(array $columns)
    {
        return $this->setHead(new Head($columns))->getHead();
    }

    /**
     * @return Row
     * @throws \Admin\Exception\RuntimeException
     */
    public function createRow()
    {
        if (!$this->getHead()) {
            throw new RuntimeException('Table must have head');
        }

        return $this->rows[] = new Row($this->getHead()->getFields());
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getRows());
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->getRows());
    }
}