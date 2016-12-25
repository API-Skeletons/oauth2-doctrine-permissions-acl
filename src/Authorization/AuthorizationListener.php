<?php

namespace ZF\OAuth2\Doctrine\Permissions\Authorization;

use ZF\MvcAuth\MvcAuthEvent;
use ZF\OAuth2\Doctrine\Permissions\Role\ObjectRepositoryProvider;
use Doctrine\ORM\EntityRepository;
use ZF\OAuth2\Doctrine\Permissions\Identity\AuthenticatedIdentity as DoctrineAuthenticatedIdentity;

class AuthorizationListener
{
    protected $roleProvider;

    public function __construct(
        ObjectRepositoryProvider $roleProvider
    ) {
        $this->roleProvider = $roleProvider;
    }

    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        $authorization = $mvcAuthEvent->getAuthorizationService();

        // Add all roles
        foreach ($this->roleProvider->getRoles() as $role) {
            $authorization->addRole($role, $role->getParent());
        }
    }
}
