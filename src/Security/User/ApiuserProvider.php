<?php

namespace App\Security\User;

use App\Security\User\ApiUser;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;


class ApiuserProvider implements UserProviderInterface
{
    private $userRep;

    public function __construct(UserRepository $userRep)
    {
        $this->userRep =  $userRep;
    }

    public function loadUserByUsername($username)
    {
        return $this->fetchUser($username);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof ApiUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        $username = $user->getUsername();

        return $this->fetchUser($username);
    }

    public function supportsClass($class)
    {
        return ApiUser::class === $class;
    }

    private function fetchUser($username)
    {
        // make a call to your webservice here
        $userData = $this->userRep->findOneBy(['username' => $username]);
        if(!$userData){
            return false;
        }
        // pretend it returns an array on success, false if there is no user

        if ($userData) {
            $password = $userData->getPassword();

            // ...

            return new ApiUser($username, $password, '', []);
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }
}