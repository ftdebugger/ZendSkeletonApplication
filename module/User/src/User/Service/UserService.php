<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace User\Service;

use Doctrine\ORM\EntityManager;
use User\Entity\User;
use User\Exception\RuntimeException;
use User\Repository\UserRepository;
use Zend\Authentication\AuthenticationService;
use Zend\Crypt\Password\Bcrypt;
use Zend\Math\Rand;
use Zend\Paginator\Paginator;
use Zend\ServiceManager\ServiceManager;
use ZfcUser\Service\User as ZfcUserService;

class UserService
{

    CONST ERIP_ID_LENGTH = 6;

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * @var ZfcUserService
     */
    protected $userService;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var User
     */
    protected $user;

    /**
     * @param ServiceManager $serviceManager
     */
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @param  int $id
     * @return User
     * @throws RuntimeException
     */
    public function loadById($id)
    {
        $user = $this->getRepository()->find($id);
        if (!$user) {
            throw new RuntimeException('Cannot find user (' . $id . ')');
        }

        return $user;
    }

    /**
     * @param  string $mail
     * @throws RuntimeException
     * @param  string $mail
     *
     * @return User
     */
    public function loadByMail($mail)
    {
        $user = $this->getRepository()->findOneBy(['email' => $mail]);
        if (!$user) {
            throw new RuntimeException('Cannot find user (' . $mail . ')');
        }

        return $user;
    }

    /**
     * @param  array $criteria
     * @return Paginator
     */
    public function getUsers(array $criteria = [])
    {
        return $this->getRepository()->getUsers($criteria);
    }

    /**
     * @throws RuntimeException
     * @return User
     */
    public function getCurrentUser()
    {
        if (null === $this->user) {
            $this->user = $this->getAuthService()->getIdentity();

            if (!$this->user) {
                throw new RuntimeException('User not logged');
            }
        }

        return $this->user;
    }

    /**
     * @return bool
     */
    public function hasCurrentUser()
    {
        try {
            $this->getCurrentUser();

            return true;
        } catch (RuntimeException $e) {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getCurrentRole()
    {
        if ($this->hasCurrentUser()) {
            return $this->getCurrentUser()->getRole();
        }

        return 'guest';
    }


    /**
     * Return value of AuthService
     *
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthService()
    {
        if (!$this->authService) {
            $this->authService = $this->serviceManager->get('zfcuser_auth_service');
        }

        return $this->authService;
    }

    /**
     * Return value of UserService
     *
     * @return \ZfcUser\Service\User
     */
    public function getUserService()
    {
        if (!$this->userService) {
            $this->userService = $this->serviceManager->get('zfcuser_user_service');
        }

        return $this->userService;
    }

    /**
     * @return UserRepository
     */
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('User\Entity\User');
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->serviceManager->get('entity_manager');
    }

}
