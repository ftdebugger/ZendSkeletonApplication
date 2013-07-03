<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin;

use Admin\Entities\EntityOptions;
use Admin\Exception\RuntimeException;
use Zend\Stdlib\AbstractOptions;

class Configuration extends AbstractOptions
{

    /**
     * @var array
     */
    protected $entities = array();

    /**
     * Set value of Entities
     *
     * @param  array                      $entities
     * @throws Exception\RuntimeException
     */
    public function setEntities($entities)
    {
        if (!is_array($entities)) {
            throw new RuntimeException('entities must be array');
        }

        $this->entities = array_map(
            function ($entity) {
                return new EntityOptions($entity);
            },
            $entities
        );
    }

    /**
     * Return value of Entities
     *
     * @return EntityOptions[]
     */
    public function getEntities()
    {
        return $this->entities;
    }

}
