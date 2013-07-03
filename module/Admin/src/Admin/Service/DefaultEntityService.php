<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin\Service;

use Admin\Entities\Entity;
use Admin\Exception\RuntimeException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\Element\Button;
use Zend\Form\Form;
use Zend\Paginator\Paginator;
use Zend\ServiceManager\ServiceManager;

class DefaultEntityService implements EntityServiceInterface
{

    /**
     * @var Entity
     */
    protected $entity;

    /**
     * @var ServiceManager
     */
    protected $serviceLocator;

    /**
     * @param Entity $entity
     * @param ServiceManager $serviceLocator
     */
    public function __construct($entity, $serviceLocator)
    {
        $this->entity = $entity;
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return Paginator
     */
    public function getList()
    {
        $query = $this->getRepository()->createQueryBuilder('e');

        $pagination = new ORMPaginator($query);
        $pagination = new DoctrinePaginator($pagination);
        $pagination = new Paginator($pagination);

        return $pagination;
    }

    /**
     * @return mixed
     */
    public function factory()
    {
        $entity = $this->entity->getClassName();
        return new $entity;
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        $builder = new AnnotationBuilder();
        $form = $builder->createForm($this->entity->getClassName());
        $form->add(new Button('submit', ['label' => 'save']));
        $form->get('submit')->setAttribute('type', 'submit');

        return $form;
    }

    /**
     * @param int $id
     * @throws RuntimeException
     * @return mixed
     */
    public function loadById($id)
    {
        $entity = $this->getRepository()->find($id);
        if (!$entity) {
            throw new RuntimeException('Entity not found');
        }

        return $entity;
    }

    /**
     * @param $model
     */
    public function save($model)
    {
        $this->getEntityManager()->persist($model);
    }

    /**
     * Remove entity
     *
     * @param mixed $model
     */
    public function remove($model)
    {
        $this->getEntityManager()->remove($model);
    }

    /**
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository(
            $this->entity->getClassName()
        );
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->serviceLocator->get('entity_manager');
    }

}