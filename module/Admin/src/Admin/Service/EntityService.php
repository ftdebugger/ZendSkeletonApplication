<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin\Service;

use Admin\Entities\Container;
use Admin\Entities\Entity;
use Admin\Table\Row;
use Admin\Table\Table;
use Zend\Paginator\Paginator;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\ClassMethods;

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
     * @param Entity $entity
     * @param Paginator $pagination
     */
    public function createTable(Entity $entity, Paginator $pagination)
    {
        $table = new Table();
        $table->createHead($entity->getOptions()->getFields());

        $hydrator = new ClassMethods();
        foreach ($pagination as $entity) {
            $row = $table->createRow();
            foreach ($hydrator->extract($entity) as $key => $value) {
                $row->setValue($key, $value);
            }
        }

        return $table;
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
