<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin\Service;

use Admin\Exception\RuntimeException;
use Zend\Form\Form;
use Zend\Paginator\Paginator;

interface EntityServiceInterface
{

    /**
     * @return Paginator
     */
    public function getList(array $criteria = array());

    /**
     * @return mixed
     */
    public function factory();

    /**
     * @return Form
     */
    public function getForm();

    /**
     * @return Form
     */
    public function getFilterForm();

    /**
     * @param  int              $id
     * @throws RuntimeException
     * @return mixed
     */
    public function loadById($id);

    /**
     * @param $model
     */
    public function save($model);

    /**
     * Remove entity
     *
     * @param mixed $model
     */
    public function remove($model);

}
