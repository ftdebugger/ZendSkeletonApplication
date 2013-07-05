<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin\Table;

class Head extends Row
{

    /**
     * @param array $columns
     */
    public function __construct(array $columns)
    {
        parent::__construct($columns);
        foreach ($columns as $key) {
            $name = str_replace('_', ' ', $key);
            $name = ucfirst($name);

            $this->setValue($key, $name);
        }
    }

}