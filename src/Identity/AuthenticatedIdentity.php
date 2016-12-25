<?php

namespace ZF\OAuth2\Doctrine\Permissions\Acl\Identity;

use ZF\MvcAuth\Identity\IdentityInterface;
use Zend\Permissions\Rbac\AbstractRole as AbstractRbacRole;

class AuthenticatedIdentity extends AbstractRbacRole implements
    IdentityInterface
{
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
        if (method_exists($this->accessToken->getUser(), 'getRole')) {
            return $this->accessToken->getUser()->getRole()->getRoleId();
        }
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
