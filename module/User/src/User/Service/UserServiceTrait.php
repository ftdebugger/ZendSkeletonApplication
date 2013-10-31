<?php

namespace User\Service;

use User\Service\UserService;
use User\Exception\RuntimeException;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

trait UserServiceTrait
{

    /**
     * @var UserService
     */
    protected $userService = null;

    /**
     * @param UserService $userService
     */
    public function setUserService(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return UserService
     * @throws RuntimeException
     */
    public function getUserService()
    {
        if (null === $this->userService) {
            if ($this instanceof ServiceLocatorAwareInterface || method_exists($this, 'getServiceLocator')) {
                $this->userService = $this->getServiceLocator()->get('UserService');
            } else {
                if (property_exists($this, 'serviceLocator')
                    && $this->serviceLocator instanceof ServiceLocatorInterface
                ) {
                    $this->userService = $this->serviceLocator->get('UserService');
                } else {
                    throw new RuntimeException('Service locator not found');
                }
            }
        }

        return $this->userService;
    }

}
