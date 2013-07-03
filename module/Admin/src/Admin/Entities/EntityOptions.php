<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin\Entities;

use Admin\Exception\RuntimeException;
use Zend\Stdlib\AbstractOptions;

class EntityOptions extends AbstractOptions
{

    const ALLOW_LIST = 'list';
    const ALLOW_CREATE = 'create';
    const ALLOW_EDIT = 'edit';
    const ALLOW_REMOVE = 'remove';

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
     * @var array
     */
    protected $allow = ['list', 'create', 'edit', 'remove'];

    /**
     * @var array
     */
    protected $filter;

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
     * @param  array                             $fields
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

    /**
     * Set value of Allow
     *
     * @param array $allow
     */
    public function setAllow($allow)
    {
        $this->allow = $allow;
    }

    /**
     * Return value of Allow
     *
     * @return array
     */
    public function getAllow()
    {
        return $this->allow;
    }

    /**
     * Set value of Filter
     *
     * @param  array                             $filter
     * @throws \Admin\Exception\RuntimeException
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * Return value of Filter
     *
     * @return array
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @return bool
     */
    public function isAllowCreate()
    {
        return in_array(self::ALLOW_CREATE, $this->getAllow());
    }

    /**
     * @return bool
     */
    public function isAllowEdit()
    {
        return in_array(self::ALLOW_EDIT, $this->getAllow());
    }

    /**
     * @return bool
     */
    public function isAllowRemove()
    {
        return in_array(self::ALLOW_REMOVE, $this->getAllow());
    }

    /**
     * @return bool
     */
    public function isAllowList()
    {
        return in_array(self::ALLOW_LIST, $this->getAllow());
    }

}
