<?php

namespace ApiSkeletons\OAuth2\Doctrine\Permissions\Acl\Authorization;

use ApiSkeletons\OAuth2\Doctrine\Permissions\Acl\Role\ObjectRepositoryProvider;
use Interop\Container\ContainerInterface;
use GianArb\Angry\Unclonable;
use GianArb\Angry\Unserializable;

class AuthorizationListenerFactory
{
    use Unclonable;
    use Unserializable;

    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        // If the Role configuration exists
        if (isset($config['apiskeletons-oauth2-doctrine-permissions-acl']['role'])) {
            $objectManager = $container->get(
                $config['apiskeletons-oauth2-doctrine-permissions-acl']['role']['object_manager']
            );
            $objectRepositoryProvider = new ObjectRepositoryProvider(
                $objectManager->getRepository(
                    $config['apiskeletons-oauth2-doctrine-permissions-acl']['role']['entity']
                )
            );
        } else {
            // Return an empty provider
            $objectRepositoryProvider = new ObjectRepositoryProvider();
        }

        return new AuthorizationListener($objectRepositoryProvider);
    }
}
