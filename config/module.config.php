<?php

namespace ZF\OAuth2\Doctrine\Permissions\Acl;

use ZF\MvcAuth\Authorization\AuthorizationInterface as MvcAuthAuthorizationInterface;

return [
    'service_manager' => [
        'aliases'    => [
            MvcAuthAuthorizationInterface::class => Authorization\AclAuthorization::class,
        ],
        'factories' => [
            Authentication\AuthenticationPostListener::class =>
                Authentication\AuthenticationPostListenerFactory::class,
            Authorization\AuthorizationListener::class =>
                Authorization\AuthorizationListenerFactory::class,
            Authorization\AclAuthorization::class => Factory\AclAuthorizationFactory::class,
        ],
    ],
];