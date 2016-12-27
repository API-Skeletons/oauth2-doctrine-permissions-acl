<?php

namespace ZF\OAuth2\Doctrine\Permissions\Acl\Authentication;

use Interop\Container\ContainerInterface;
use GianArb\Angry\Unclonable;
use GianArb\Angry\Unserializable;

class AuthenticationPostListenerFactory
{
    use Unclonable;
    use Unserializable;

    public function __invoke(ContainerInterface $container)
    {
        return new AuthenticationPostListener($container);
    }
}
