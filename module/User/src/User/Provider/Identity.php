<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace User\Provider;

use BjyAuthorize\Provider\Identity\ProviderInterface;
use User\Service\UserService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Identity implements ProviderInterface
{

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Retrieve roles for the current identity
     *
     * @return string[]|\Zend\Permissions\Acl\Role\RoleInterface[]
     */
    public function getIdentityRoles()
    {
        return [$this->userService->getCurrentRole()];
    }

}
