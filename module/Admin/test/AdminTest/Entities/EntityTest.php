<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace AdminTest\Entities;


use Admin\Entities\Entity;
use Admin\Entities\EntityOptions;

class EntityTest extends \PHPUnit_Framework_TestCase
{

    public function testGetServiceWithServiceManager()
    {
        $entity = new Entity('test', new EntityOptions(['service' => 'test-service']));

        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceManager', ['has', 'get']);
        $serviceLocator->expects($this->once())->method('has')->with('test-service')->will($this->returnValue(true));
        $serviceLocator->expects($this->once())->method('get')->with('test-service')->will($this->returnValue(true));

        $entity->setServiceLocator($serviceLocator);

        $this->assertTrue($entity->getService());
    }

    public function testGetServiceWithInstantination()
    {
        $entity = new Entity('test', new EntityOptions(['service' => 'stdClass']));

        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceManager', ['has']);
        $serviceLocator->expects($this->once())->method('has')->with('stdClass')->will($this->returnValue(false));
        $entity->setServiceLocator($serviceLocator);

        $this->assertInstanceOf('stdClass', $entity->getService());
    }

    public function testGetServiceCreateDefault()
    {
        $entity = new Entity('test', new EntityOptions());
        $entity->setServiceLocator($this->getMock('Zend\ServiceManager\ServiceManager'));

        $this->assertInstanceOf('Admin\Service\DefaultEntityService', $entity->getService());
    }

    /**
     * @expectedException \Admin\Exception\RuntimeException
     */
    public function testGetServiceUnknown()
    {
        $entity = new Entity('test', new EntityOptions(['service' => 'admintest\notexists\class']));

        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceManager', ['has']);
        $serviceLocator->expects($this->once())->method('has')->will($this->returnValue(false));
        $entity->setServiceLocator($serviceLocator);

        $entity->getService();
    }

    public function testGetClassName()
    {
        $entity = new Entity('test', new EntityOptions(['entity' => 'User\Entity\User']));
        $this->assertEquals('User\Entity\User', $entity->getClassName());
    }

    public function testGetName()
    {
        $entity = new Entity('test', new EntityOptions());
        $this->assertEquals('test', $entity->getName());

    }

}
