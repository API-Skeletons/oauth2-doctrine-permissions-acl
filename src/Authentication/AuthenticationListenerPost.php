<?php

namespace ZF\OAuth2\Doctrine\Permissions\Authentication;

use Interop\Container\ContainerInterface;
use ZF\MvcAuth\MvcAuthEvent;
use ZF\MvcAuth\Identity\AuthenticatedIdentity as MvcAuthAuthenticatedIdentity;
use ZF\OAuth2\Doctrine\Permissions\Identity\AuthenticatedIdentity as DoctrineAuthenticatedIdentity;
use ZF\OAuth2\Dooctrine\Permissions\Exception;

class AuthenticationListener
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    // Replace an Authenticated Identity with a Doctrine enabled identity
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        $identity = $mvcAuthEvent->getAuthenticationService()->getIdentity();
        if (! $identity instanceof MvcAuthAuthenticatedIdentity) {
            return;
        }

        $accessToken = $this->findAccessToken($identity->getAuthenticationIdentity());
        if (! $accessToken) {
            throw new Exception\AccessTokenException('Access Token expected for authenticated identity not found');
        }

        $doctrineAuthenticatedIdentity = new DoctrineAuthenticatedIdentity($accessToken);
        $mvcAuthEvent->setIdentity($doctrineAuthenticatedIdentity);
    }

    // Search each OAuth2 configuration for a matching clientId and access_token
    private function findAccessToken(array $identity)
    {
        $config = $this->container->get('config');

        foreach ($config['zf-oauth2-doctrine'] as $oauth2Config) {
            $objectManager = $this->container->get($oauth2Config['object_manager']);
            $accessTokenRepository = $objectManger->getRepository($oauth2Config['mapping']['AccessToken']['entity']);

            $accessToken = $accessTokenRepository->findOneBy([
                $oauth2Config['mapping']['AccessToken']['mapping']['access_token']['name']
                    => $identity['access_token'],
            ]);

            if ($accessToken) {
                if ($accessToken->getClient()->getClientId() == $identity['client_id']) {
                    // Match found
                    return $accessToken;
                }
            }
        }
    }
}
