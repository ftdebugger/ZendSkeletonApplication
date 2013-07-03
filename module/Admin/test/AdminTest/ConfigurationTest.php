<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace AdminTest;

use Admin\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    public function testSetEntities()
    {
        $configuration = new Configuration(
            array(
                 'entities' => array(
                     'user' => array(),
                     'test' => array()
                 )
            )
        );
        $entities = $configuration->getEntities();
        $this->assertCount(2, $entities);
        $this->assertInstanceOf('Admin\Entities\EntityOptions', $entities['user']);
        $this->assertInstanceOf('Admin\Entities\EntityOptions', $entities['test']);
    }

    /**
     * @expectedException \Admin\Exception\RuntimeException
     */
    public function testSetEntitiesWrongConfiguration()
    {
        new Configuration(array('entities' => 123));
    }

}
