<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin\Service;

use Admin\Entities\Container;
use Admin\Entities\Entity;
use Zend\ServiceManager\ServiceManager;

class EntityService
{

    /**
     * @var ServiceManager
     */
    protected $serviceLocator;

    /**
     * @param $serviceLocator
     */
    public function __construct($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param  string $name
     * @return Entity
     */
    public function getEntity($name)
    {
        return $this->getEntities()->getEntity($name);
    }

    /**
     * @return Container
     */
    public function getEntities()
    {
        return $this->getServiceLocator()->get('admin-entities');
    }

    /**
     * Return value of ServiceLocator
     *
     * @return ServiceManager
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}
