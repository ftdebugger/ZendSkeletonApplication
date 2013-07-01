<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace User\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;

class UserRepository extends EntityRepository
{

    /**
     * @param  array     $criteria
     * @return Paginator
     */
    public function getUsers(array $criteria = array())
    {
        $query = $this->createQueryBuilder('u');
        $query->orderBy('u.displayName', 'asc');

        $pagination = new ORMPaginator($query);
        $pagination = new DoctrinePaginator($pagination);
        $pagination = new Paginator($pagination);

        return $pagination;
    }

}
