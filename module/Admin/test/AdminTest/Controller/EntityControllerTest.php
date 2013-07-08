<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace AdminTest\Controller;


use Admin\Controller\EntityController;
use Admin\Entities\Entity;
use Admin\Entities\EntityOptions;
use AdminTest\Mock\EntityMock;
use Zend\Form\Form;
use Zend\Mvc\Controller\Plugin\Params;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class EntityControllerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var EntityController
     */
    protected $object;

    /**
     * @var Params|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $paramsPlugin;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $entityService;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $request;

    public function setUp()
    {

    }

    public function testListActionNotFound()
    {
        $errorView = new ViewModel();

        $entity = new Entity('user', new EntityOptions(['allow' => []]));
        $controller = $this->getController(['loadEntity', 'notFoundAction']);
        $controller->expects($this->once())->method('loadEntity')->will($this->returnValue($entity));
        $controller->expects($this->once())->method('notFoundAction')->will($this->returnValue($errorView));

        $this->assertSame($errorView, $controller->listAction(), 'Return value');
    }

    public function testListAction()
    {
        $entity = $this->getEntity();
        $controller = $this->getController(['loadEntity', 'notFoundAction']);
        $controller->expects($this->once())->method('loadEntity')->will($this->returnValue($entity));

        $this->paramsPlugin->expects($this->any())->method('fromQuery')->will($this->returnValue(['a' => 1]));
        $this->paramsPlugin->expects($this->once())->method('fromRoute')->with('page')
            ->will($this->returnValue(2));

        $entities = new Paginator(
            new ArrayAdapter(
                array(
                     new EntityMock(),
                     new EntityMock(),
                )
            )
        );

        $entity->getService()->expects($this->once())->method('getFilterForm')->will($this->returnValue(new Form()));
        $entity->getService()->expects($this->once())->method('getList')->with([])
            ->will($this->returnValue($entities));

        $controller->listAction();
    }

    public function testLoadEntity()
    {
        $this->getController();
        $this->paramsPlugin->expects($this->once())->method('fromRoute')->with('entity')
            ->will($this->returnValue('user'));
        $this->entityService->expects($this->once())->method('getEntity')->with('user');

        $this->object->loadEntity();
    }

    /**
     * @param array $mock
     * @return EntityController|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getController(array $mock = [])
    {
        $this->paramsPlugin = $this->getMock(
            'Zend\Mvc\Controller\Plugin\Params',
            ['fromRoute', 'fromQuery', 'fromPost']
        );
        $this->entityService = $this->getMockBuilder('Admin\Service\EntityService')
            ->disableOriginalConstructor()->getMock();
        $this->entityService->expects($this->any())->method('getForm')
            ->will($this->returnValue(new Form()));
        $this->request = $this->getMock('Zend\Http\Request');

        $pluginManager = $this->getMock('Zend\Mvc\Controller\PluginManager');
        $pluginManager->expects($this->any())->method('get')->with('params')
            ->will($this->returnValue($this->paramsPlugin));

        if (count($mock)) {
            $this->object = $this->getMock('Admin\Controller\EntityController', $mock);
        } else {
            $this->object = new EntityController();
        }
        $this->object->setEntityService($this->entityService);
        $this->object->setPluginManager($pluginManager);

        $property = new \ReflectionProperty($this->object, 'request');
        $property->setAccessible(true);
        $property->setValue($this->object, $this->request);

        return $this->object;
    }

    protected function getEntity()
    {
        $entity = new Entity('user', new EntityOptions());
        $entity->setService(
            $this->getMockBuilder('Admin\Service\DefaultEntityService')
                ->disableOriginalConstructor()->getMock()
        );

        return $entity;
    }
}
