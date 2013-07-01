<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace User\Controller\Plugin;

use BjyAuthorize\Service\Authorize;
use User\Service\UserService;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Permissions\Acl\Acl;
use Zend\ServiceManager\ServiceManager;

class Authentication extends AbstractPlugin
{

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var Acl
     */
    protected $acl;

    /**
     * @var ServiceManager
     */
    protected $serviceLocator;

    /**
     * @param $serviceLocator
     */
    public function __construct($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @return \User\Entity\User
     */
    public function getUser()
    {
        return $this->getUserService()->getCurrentUser();
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->getUserService()->getCurrentRole();
    }

    /**
     * @return bool
     */
    public function hasUser()
    {
        return $this->getUserService()->hasCurrentUser();
    }

    /**
     * @param string $resource
     * @param string $role
     * @param string $privilege
     *
     * @return bool
     */
    public function isAllowed($resource, $role = null, $privilege = null)
    {
        if (null === $role) {
            $role = $this->getRole();
        }

        return $this->getAcl()->isAllowed($resource, $role, $privilege);
    }

    /**
     * Set value of Acl
     *
     * @param \Zend\Permissions\Acl\Acl $acl
     */
    public function setAcl($acl)
    {
        $this->acl = $acl;
    }

    /**
     * Return value of Acl
     *
     * @return \Zend\Permissions\Acl\Acl
     */
    public function getAcl()
    {
        if (null === $this->acl) {
            /** @var Authorize $auth */
            $auth = $this->serviceLocator->get('BjyAuthorize\Service\Authorize');
            $this->acl = $auth->getAcl();
        }

        return $this->acl;
    }

    /**
     * Set value of UserService
     *
     * @param \User\Service\UserService $userService
     */
    public function setUserService($userService)
    {
        $this->userService = $userService;
    }

    /**
     * Return value of UserService
     *
     * @return \User\Service\UserService
     */
    public function getUserService()
    {
        if (!$this->userService) {
            $this->userService = $this->serviceLocator->get('UserService');
        }

        return $this->userService;
    }

}
