<?php

namespace ZF\OAuth2\Doctrine\Permissions;

return [
    'service_manager' => [
        'factories' => [
            Authentication\AuthenticationPostListener::class =>
                Authentication\AuthenticationPostListenerFactory::class,
        ],
    ],
];