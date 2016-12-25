<?php

namespace ZF\OAuth2\Doctrine\Permissions\Acl\Authorization;

use ZF\OAuth2\Doctrine\Permissions\Acl\Role\ObjectRepositoryProvider;
use Interop\Container\ContainerInterface;

class AuthorizationListenerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        // If the Role configuration exists
        if (isset($config['zf-oauth2-doctrine-permissions-acl']['role']) {
            $objectManager = $container->get($config['zf-oauth2-doctrine-permissions-acl']['role']['object_manager']);
            $objectRepositoryProvider = new ObjectRepositoryProvider(
                $objectManager->getRepository($config['zf-oauth2-doctrine-permissions-acl']['role']['entity'])
            );
        } else {
            // Return an empty provider
            $objectRepositoryProvider = new ObjectRepositoryProvider();
        }

        return new AuthorizationListener($objectRepositoryProvider);
    }
}