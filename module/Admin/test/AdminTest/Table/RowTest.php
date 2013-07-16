<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace AdminTest\Table;


use Admin\Table\Row;

class RowTest extends \PHPUnit_Framework_TestCase
{

    public function testSetValue()
    {
        $row = new Row(['id', 'username']);
        $row->setValue('id', 12);
        $row->setValue('username', 'John');

        $this->assertEquals(['id' => 12, 'username' => 'John'], iterator_to_array($row));
    }

    public function testSetValueNotExists()
    {
        $row = new Row(['id', 'username']);
        $row->setValue('id', 12);
        $row->setValue('username', 'John');
        $row->setValue('mail', 'John@mail.ru');

        $this->assertEquals(['id' => 12, 'username' => 'John'], iterator_to_array($row));
    }

    public function testGetFieldse()
    {
        $row = new Row(['id', 'username']);
        $this->assertEquals(['id', 'username'], $row->getFields());
    }

    public function testOffsetSet()
    {
        $row = new Row(['a']);
        $row['a'] = 1;
        $row['b'] = 2;
        $this->assertEquals(['a' => 1], iterator_to_array($row));
    }

    public function testOffsetGet()
    {
        $row = new Row(['a']);
        $row['a'] = 112;
        $this->assertEquals(112, $row['a']);
    }

    public function testOffsetUnset()
    {
        $row = new Row(['a']);
        $row['a'] = 112;
        $this->assertEquals(112, $row['a']);
        unset($row['a']);
        $this->assertEquals("", $row['a']);
    }

    public function testOffsetIsset()
    {
        $row = new Row(['a']);
        $this->assertTrue(isset($row['a']));
        $this->assertFalse(isset($row['b']));
    }

}
