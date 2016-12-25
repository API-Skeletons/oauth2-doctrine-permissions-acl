<?php

namespace ZF\OAuth2\Doctrine\Permissions\Acl;

return [
    'service_manager' => [
        'aliases'    => [
            AuthorizationInterface::class => Authorization\AclAuthorization::class,
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