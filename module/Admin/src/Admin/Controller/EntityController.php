<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin\Controller;

use Admin\Entities\Entity;
use Admin\Service\EntityService;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;

class EntityController extends AbstractActionController
{

    /**
     * @var EntityService
     */
    protected $entityService;

    /**
     * @return array
     */
    public function indexAction()
    {
        return array(
            'entities' => $this->getEntityService()->getEntities()->getEntities()
        );
    }

    /**
     * @return array
     */
    public function listAction()
    {
        $entity = $this->loadEntity();

        if (!$entity->getOptions()->isAllowList()) {
            return $this->notFoundAction();
        }

        $filter = $entity->getService()->getFilterForm();
        $filter->setData($this->params()->fromQuery());
        $filter->isValid();

        $list = $entity->getService()->getList($filter->getData());
        $list->setCurrentPageNumber($this->params()->fromRoute('page'));

        $table = $this->getEntityService()->createTable($entity, $list);

        return array(
            'entity' => $entity,
            'paginator' => $list,
            'table' => $table,
            'filter' => $filter
        );
    }

    public function createAction()
    {
        $entityName = $this->params()->fromRoute('entity');
        $entity = $this->getEntityService()->getEntity($entityName);

        if (!$entity->getOptions()->isAllowCreate()) {
            return $this->notFoundAction();
        }

        $form = $this->editModel($entity, $entity->getService()->factory());

        return array(
            'entity' => $entity,
            'form' => $form
        );
    }

    public function editAction()
    {
        $entityName = $this->params()->fromRoute('entity');
        $entity = $this->getEntityService()->getEntity($entityName);

        if (!$entity->getOptions()->isAllowEdit()) {
            return $this->notFoundAction();
        }

        $model = $entity->getService()->loadById($this->params()->fromRoute('id'));

        $form = $this->editModel($entity, $model);

        return array(
            'entity' => $entity,
            'form' => $form
        );
    }

    public function removeAction()
    {
        $entity = $this->loadEntity();

        if (!$entity->getOptions()->isAllowRemove()) {
            return $this->notFoundAction();
        }

        $model = $entity->getService()->loadById($this->params()->fromPost('id'));
        $entity->getService()->remove($model);
        $this->getEntityManager()->flush();

        $this->redirect()->toRoute('admin/entity/entity', ['entity' => $entity->getName()]);

        return [];
    }

    /**
     * @param Entity $entity
     * @param $model
     * @return array
     */
    public function editModel($entity, $model)
    {
        $form = $entity->getService()->getForm();
        $form->bind($model);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $entity->getService()->save($model);
                $this->getEntityManager()->flush();
                $this->flashMessenger()->addSuccessMessage('Saved');
                $this->redirect()->toRoute('admin/entity/entity', ['entity' => $entity->getName()]);
            }
        }

        return $form;
    }

    /**
     * @return Entity
     */
    public function loadEntity()
    {
        $entityName = $this->params()->fromRoute('entity');
        return $this->getEntityService()->getEntity($entityName);
    }

    /**
     * Return value of EntityService
     *
     * @return \Admin\Service\EntityService
     */
    public function getEntityService()
    {
        if (null === $this->entityService) {
            $this->entityService = $this->getServiceLocator()->get('Admin\Service\EntityService');
        }

        return $this->entityService;
    }

    /**
     * Set value of EntityService
     *
     * @param \Admin\Service\EntityService $entityService
     */
    public function setEntityService($entityService)
    {
        $this->entityService = $entityService;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('entity_manager');
    }

}
