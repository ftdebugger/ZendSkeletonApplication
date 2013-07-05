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
use Zend\Form\Element\Text;
use Zend\Form\Factory;
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
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param Entity         $entity
     * @param ServiceManager $serviceLocator
     */
    public function __construct($entity, $serviceLocator)
    {
        $this->entity = $entity;
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param  array     $criteria
     * @return Paginator
     */
    public function getList(array $criteria = array())
    {
        $query = $this->getRepository()->createQueryBuilder('e');

        foreach ($this->filterCriteria($criteria) as $key => $value) {
            $query->andWhere('e.' . $key . ' like :' . $key);
            $query->setParameter($key, $value . '%');
        }

        $pagination = new ORMPaginator($query);
        $pagination = new DoctrinePaginator($pagination);
        $pagination = new Paginator($pagination);

        return $pagination;
    }

    /**
     * @param array $criteria
     *
     * @return array
     */
    protected function filterCriteria(array $criteria = array())
    {
        $result = array();

        $meta = $this->getEntityManager()->getClassMetadata($this->entity->getClassName());

        foreach ($criteria as $key => $value) {
            if ($value != '') {
                if (isset($meta->fieldNames[$key])) {
                    $key = $meta->fieldNames[$key];
                }

                if (isset($meta->fieldMappings[$key])) {
                    $result[$key] = $value;
                }
            }
        }

        return $result;
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
     * @throws RuntimeException
     * @return Form
     */
    public function getFilterForm()
    {
        $filters = $this->entity->getOptions()->getFilter();

        if ($filters) {
            if (is_string($filters)) {
                $form = $this->serviceLocator->get($filters);
            } elseif (is_array($filters)) {
                $simple = true;
                foreach ($filters as $filter) {
                    $simple = $simple && is_string($filter);
                }

                if ($simple) {
                    $form = new Form();
                    $form->setAttribute('method', 'GET');

                    foreach ($filters as $filter) {
                        $label = str_replace('_', ' ', $filter);
                        $form->add(new Text($filter, ['label' => $label]));
                    }
                    $submit = new Button('submit', ['label' => 'Filter']);
                    $submit->setAttribute('type', 'submit');
                    $form->add($submit);

                } else {
                    $factory = new Factory();
                    $form = $factory->createForm($filters);
                }
            } else {
                throw new RuntimeException('Unknown type of filter');
            }

            return $form;
        }

        return new Form();
    }

    /**
     * @param  int              $id
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
     * @param  mixed      $model
     * @return mixed|void
     */
    public function remove($model)
    {
        $this->getEntityManager()->remove($model);
    }

    /**
     * Set value of Repository
     *
     * @param EntityRepository $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return EntityRepository
     */
    public function getRepository()
    {
        if (null == $this->repository) {
            $this->repository = $this->getEntityManager()->getRepository(
                $this->entity->getClassName()
            );
        }

        return $this->repository;
    }

    /**
     * Set value of EntityManager
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->entityManager = $this->serviceLocator->get('entity_manager');
        }

        return $this->entityManager;
    }

}
