<?php

namespace ZF\OAuth2\Doctrine\Permissions\Acl;

use ZF\MvcAuth\Authorization\AuthorizationInterface as MvcAuthAuthorizationInterface;

class ConfigProvider
{
    /**
     * Provide configuration for this component.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    /**
     * Provide dependency configuration for this component.
     *
     * @return array
     */
    public function getDependencyConfig()
    {
        return [
            'aliases'    => [
                MvcAuthAuthorizationInterface::class => Authorization\AclAuthorization::class,
            ],
            'factories' => [
                Authorization\AuthorizationListener::class =>
                    Authorization\AuthorizationListenerFactory::class,
                Authorization\AclAuthorization::class => Factory\AclAuthorizationFactory::class,
            ],
        ];
    }
}
