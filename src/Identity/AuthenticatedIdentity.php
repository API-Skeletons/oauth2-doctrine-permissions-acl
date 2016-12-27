<?php

namespace ZF\OAuth2\Doctrine\Permissions\Acl\Identity;

use ZF\MvcAuth\Identity\IdentityInterface;
use Zend\Permissions\Rbac\AbstractRole as AbstractRbacRole;
use ZF\OAuth2\Doctrine\Permissions\Acl\Role\ProviderInterface;
use ZF\OAuth2\Doctrine\Permissions\Acl\Exception;
use GianArb\Angry\Uninvokable;

class AuthenticatedIdentity extends AbstractRbacRole implements
    IdentityInterface
{
    use Uninvokable;

    protected $accessToken;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getAuthenticationIdentity()
    {
        return [
            'user' => $this->getUser(),
            'client' => $this->getClient(),
            'accessToken' => $this->getAccessToken(),
        ];
    }

    public function getRoleId()
    {
        throw new Exception\InvalidAclAuthorizationException('getRoleId called direclty on AuthentictedIdentity');
    }

    public function getUser()
    {
        return $this->accessToken->getUser();
    }

    public function getClient()
    {
        return $this->accessToken->getClient();
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }
}
