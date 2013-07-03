<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace AdminTest\Navigation\Service;

use Admin\Entities\Container;
use Admin\Entities\Entity;
use Admin\Entities\EntityOptions;
use Admin\Navigation\Service\AdminNavigationFactory;
use Zend\Navigation\Page\Mvc;

class AdminNavigationFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testGetName()
    {
        $factory = new AdminNavigationFactory();
        $method = new \ReflectionMethod($factory, 'getName');
        $method->setAccessible(true);
        $this->assertEquals('admin', $method->invoke($factory));
    }

    public function testGetPages()
    {
        $pages = array(new Mvc());

        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceManager', ['get']);
        $serviceLocator->expects($this->once())->method('get')->with('Config')
            ->will($this->returnValue(array('navigation' => ['admin' => 'test'])));

        $factory = $this->getMock(
            'Admin\Navigation\Service\AdminNavigationFactory',
            ['getPagesFromConfig', 'preparePages', 'getEntitiesPage']
        );
        $factory->expects($this->once())->method('getPagesFromConfig')->with('test')->will($this->returnValue('pages'));
        $factory->expects($this->once())->method('preparePages')
            ->with($serviceLocator, 'pages')
            ->will($this->returnValue($pages));

        $entities = array(new Mvc());
        $factory->expects($this->once())->method('getEntitiesPage')->with($serviceLocator)
            ->will($this->returnValue($entities));

        $method = new \ReflectionMethod($factory, 'getPages');
        $method->setAccessible(true);
        $result = $method->invoke($factory, $serviceLocator);
        $this->assertCount(2, $result);
    }

    public function testGetEntitiesPageEmpty()
    {
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceManager', ['get']);
        $serviceLocator->expects($this->once())->method('get')->with('admin-entities')
            ->will($this->returnValue(new Container()));

        $factory = $this->getMock('Admin\Navigation\Service\AdminNavigationFactory');
        $method = new \ReflectionMethod($factory, 'getEntitiesPage');
        $method->setAccessible(true);
        $result = $method->invoke($factory, $serviceLocator);
        $this->assertCount(0, $result);
    }

    public function testGetEntitiesPage()
    {
        $container = new Container();
        $container->addEntity(new Entity('a', new EntityOptions()));
        $container->addEntity(new Entity('b', new EntityOptions(['allow' => []])));

        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceManager', ['get']);
        $serviceLocator->expects($this->once())->method('get')->with('admin-entities')
            ->will($this->returnValue($container));

        $factory = $this->getMock(
            'Admin\Navigation\Service\AdminNavigationFactory',
            ['getPagesFromConfig', 'preparePages']
        );
        $factory->expects($this->once())->method('getPagesFromConfig')
            ->with(
                array(
                     'entities' => array(
                         'label' => 'Entities',
                         'route' => 'admin/entities',
                         'resource' => 'admin',
                         'pages' => array(
                             array(
                                 'label' => 'a',
                                 'route' => 'admin/entity',
                                 'params' => array(
                                     'entity' => 'a'
                                 ),
                                 'resource' => 'admin'
                             )
                         )
                     )
                )
            )
            ->will($this->returnValue('pages'));

        $factory->expects($this->once())->method('preparePages')
            ->with($serviceLocator, 'pages')
            ->will($this->returnValue(array('abc')));

        $method = new \ReflectionMethod($factory, 'getEntitiesPage');
        $method->setAccessible(true);
        $result = $method->invoke($factory, $serviceLocator);
        $this->assertCount(1, $result);
    }

}
