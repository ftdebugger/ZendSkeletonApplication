<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace AdminTest\Entities;

use Admin\Entities\EntityOptions;

class EntityOptionsTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $options = array(
            'entity' => 'User\Entity\User',
            'fields' => array('id', 'username', 'email', 'display_name'),
            'allow' => array('list', 'edit', 'remove'),
            'filter' => array('username', 'email', 'display_name')
        );
        $entity = new EntityOptions($options);
        $this->assertEquals($options['entity'], $entity->getEntity());
        $this->assertEquals($options['fields'], $entity->getFields());
        $this->assertEquals($options['allow'], $entity->getAllow());
        $this->assertEquals($options['filter'], $entity->getFilter());
    }

    /**
     * @expectedException \Admin\Exception\RuntimeException
     */
    public function testSetFieldsAllowOnlyArrays()
    {
        new EntityOptions(['fields' => 123]);
    }

    public function testIsAllowCreate()
    {
        $options = new EntityOptions();
        $this->assertTrue($options->isAllowCreate());
        $options->setAllow([]);
        $this->assertFalse($options->isAllowCreate());
    }

    public function testIsAllowList()
    {
        $options = new EntityOptions();
        $this->assertTrue($options->isAllowList());
        $options->setAllow([]);
        $this->assertFalse($options->isAllowList());
    }

    public function testIsAllowRemove()
    {
        $options = new EntityOptions();
        $this->assertTrue($options->isAllowRemove());
        $options->setAllow([]);
        $this->assertFalse($options->isAllowRemove());
    }

    public function testIsAllowEdit()
    {
        $options = new EntityOptions();
        $this->assertTrue($options->isAllowEdit());
        $options->setAllow([]);
        $this->assertFalse($options->isAllowEdit());
    }
}
