<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin\Entities;


use Admin\Exception\RuntimeException;
use Zend\Stdlib\AbstractOptions;

class EntityOptions extends AbstractOptions
{

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var string
     */
    protected $service;

    /**
     * @var array
     */
    protected $fields = ['id', 'title'];

    /**
     * Set value of Entity
     *
     * @param string $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Return value of Entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set value of Service
     *
     * @param string $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * Return value of Service
     *
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set value of Fields
     *
     * @param array $fields
     * @throws \Admin\Exception\RuntimeException
     */
    public function setFields($fields)
    {
        if (!is_array($fields)) {
            throw new RuntimeException('"fields" must be array');
        }
        $this->fields = $fields;
    }

    /**
     * Return value of Fields
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }


}