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

}
