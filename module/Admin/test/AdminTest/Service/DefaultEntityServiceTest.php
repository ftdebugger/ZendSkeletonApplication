<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace AdminTest\Service;


use Admin\Entities\Entity;
use Admin\Entities\EntityOptions;
use Admin\Service\DefaultEntityService;
use Zend\Form\Form;

class DefaultEntityServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $service = $this->getService();
        $this->assertInstanceOf('AdminTest\Service\_files\EntityMock', $service->factory());
    }

    public function testGetForm()
    {
        $service = $this->getService();
        $form = $service->getForm();
        $this->assertInstanceOf('Zend\Form\Form', $form);
        $this->assertNotNull($form->get('submit'));
        $this->assertNotNull($form->get('name'));
    }

    public function testLoadById()
    {
        $entity = new \stdClass();

        $repository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()->getMock();

        $repository->expects($this->once())->method('find')->with(123)->will($this->returnValue($entity));

        $service = $this->getService();
        $service->setRepository($repository);

        $this->assertSame($entity, $service->loadById(123));
    }

    /**
     * @expectedException \Admin\Exception\RuntimeException
     */
    public function testLoadByIdNotFound()
    {
        $repository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()->getMock();

        $repository->expects($this->once())->method('find')->with(123)->will($this->returnValue(false));

        $service = $this->getService();
        $service->setRepository($repository);
        $service->loadById(123);
    }

    public function testRemove()
    {
        $entity = new \stdClass();

        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()->getMock();

        $entityManager->expects($this->once())->method('remove')->with($entity);

        $service = $this->getService();
        $service->setEntityManager($entityManager);
        $service->remove($entity);
    }

    public function testSave()
    {
        $entity = new \stdClass();

        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()->getMock();

        $entityManager->expects($this->once())->method('persist')->with($entity);

        $service = $this->getService();
        $service->setEntityManager($entityManager);
        $service->save($entity);
    }

    public function testFilterCriteria()
    {
        $meta = (object)array(
            'fieldNames' => array(
                'display_name' => 'displayName',
            ),
            'fieldMappings' => array(
                'displayName' => true,
                'username' => true,
            )
        );

        $manager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()->getMock();

        $manager->expects($this->once())->method('getClassMetadata')
            ->will($this->returnValue($meta));

        $service = $this->getService();
        $service->setEntityManager($manager);

        $input = array(
            'display_name' => 'John',
            'username' => 'Johny',
            'garbage' => 'must remote it'
        );

        $method = new \ReflectionMethod($service, 'filterCriteria');
        $method->setAccessible(true);
        $result = $method->invoke($service, $input);
        $this->assertEquals(['displayName' => 'John', 'username' => 'Johny'], $result);
    }

    public function testGetList()
    {
        $service = $this->getMockBuilder('Admin\Service\DefaultEntityService')
            ->disableOriginalConstructor()->setMethods(['filterCriteria'])->getMock();

        $service->expects($this->once())->method('filterCriteria')->with(['username' => 'John'])
            ->will($this->returnValue(['username' => 'John']));

        $builder = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()->getMock();
        $builder->expects($this->once())->method('andWhere')->with('e.username like :username');
        $builder->expects($this->once())->method('setParameter')->with('username', 'John%');

        $repository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()->getMock();
        $repository->expects($this->once())->method('createQueryBuilder')->with('e')
            ->will($this->returnValue($builder));

        $service->setRepository($repository);

        $paginator = $service->getList(['username' => 'John']);
        $this->assertInstanceOf('Zend\Paginator\Paginator', $paginator);
    }

    public function testGetFilterFormWithNoSetFilters()
    {
        $service = $this->getService();
        $form = $service->getFilterForm();

        $this->assertInstanceOf('Zend\Form\Form', $form);
        $this->assertCount(0, $form->getElements());
    }

    public function testGetFilterFormWithString()
    {
        $entity = $this->getEntity();
        $entity->getOptions()->setFilter('test');
        $serviceLocator = $this->getServiceLocator();
        $service = new DefaultEntityService($entity, $serviceLocator);

        $form = new Form();

        $serviceLocator->expects($this->once())->method('get')->with('test')->will($this->returnValue($form));
        $this->assertSame($form, $service->getFilterForm());
    }

    public function testGetFilterFormWithArrayFormBuilder()
    {
        $data = array(
            'elements' => array(
                array(
                    'spec' => array(
                        'name' => 'test',
                    )
                )
            )
        );

        $entity = $this->getEntity();
        $entity->getOptions()->setFilter($data);
        $serviceLocator = $this->getServiceLocator();
        $service = new DefaultEntityService($entity, $serviceLocator);

        $form = $service->getFilterForm();
        $this->assertNotNull($form->get('test'));
    }

    public function testGetFilterFormWithArraySimple()
    {
        $data = array('username', 'test');

        $entity = $this->getEntity();
        $entity->getOptions()->setFilter($data);
        $serviceLocator = $this->getServiceLocator();
        $service = new DefaultEntityService($entity, $serviceLocator);

        $form = $service->getFilterForm();
        $this->assertNotNull($form->get('test'));
        $this->assertNotNull($form->get('username'));
    }

    /**
     * @expectedException \Admin\Exception\RuntimeException
     */
    public function testGetFilterFormWithUnknown()
    {
        $entity = $this->getEntity();
        $entity->getOptions()->setFilter(123);
        $serviceLocator = $this->getServiceLocator();
        $service = new DefaultEntityService($entity, $serviceLocator);
        $service->getFilterForm();
    }

    public function testGetRepository()
    {
        $manager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()->getMock();
        $manager->expects($this->once())->method('getRepository')
            ->with('AdminTest\Service\_files\EntityMock')
            ->will($this->returnValue('repository'));

        $service = $this->getService();
        $service->setEntityManager($manager);

        $this->assertEquals('repository', $service->getRepository());
        $this->assertEquals('repository', $service->getRepository());
    }

    public function testGetEntityManager()
    {
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceManager');
        $serviceLocator->expects($this->once())->method('get')->with('entity_manager')->will(
            $this->returnValue('manager')
        );

        $service = new DefaultEntityService($this->getEntity(), $serviceLocator);

        $this->assertEquals('manager', $service->getEntityManager());
        $this->assertEquals('manager', $service->getEntityManager());
    }

    /**
     * @return DefaultEntityService
     */
    protected function getService()
    {
        return new DefaultEntityService($this->getEntity(), $this->getServiceLocator());
    }

    protected function getServiceLocator()
    {
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceManager');
        return $serviceLocator;
    }

    protected function getEntity()
    {
        return new Entity('a', new EntityOptions(['entity' => 'AdminTest\Service\_files\EntityMock']));
    }

}
