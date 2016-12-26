<?php

namespace ZF\OAuth2\Doctrine\Permissions\Acl\Authorization;

use ZF\MvcAuth\MvcAuthEvent;
use Doctrine\ORM\EntityRepository;
use ZF\OAuth2\Doctrine\Permissions\Acl\Role\ObjectRepositoryProvider;
use ZF\OAuth2\Doctrine\Permissions\Acl\Identity\AuthenticatedIdentity as DoctrineAuthenticatedIdentity;

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
