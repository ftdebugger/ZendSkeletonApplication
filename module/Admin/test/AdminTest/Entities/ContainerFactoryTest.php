<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace AdminTest\Entities;

use Admin\Configuration;
use Admin\Entities\Container;
use Admin\Entities\ContainerFactory;

class ContainerFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateService()
    {
        $config = new Configuration(
            array(
                 'entities' => array(
                     'user' => array()
                 )
            )
        );

        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceManager', ['get']);
        $serviceLocator->expects($this->once())->method('get')->with('admin-config')->will($this->returnValue($config));

        $factory = new ContainerFactory();
        /** @var Container $container */
        $container = $factory->createService($serviceLocator);
        $this->assertInstanceOf('Admin\Entities\Container', $container);
        $this->assertCount(1, $container->getEntities());
        $this->assertInstanceOf('Admin\Entities\Entity', $container->getEntity('user'));
    }

}
