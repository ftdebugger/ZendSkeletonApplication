<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace AdminTest\Mock;

use Zend\Form\Annotation as Form;

/**
 * @Form\Name("mock")
 */
class EntityMock
{

    /**
     * @Form\Name("name")
     */
    protected $name;

    /**
     * Set value of Name
     *
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Return value of Name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

}
