<?php

namespace TestApi\Authorization;

use Laminas\ApiTools\MvcAuth\MvcAuthEvent;
use Db\Fixture\RoleFixture;

class AuthorizationListener
{
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        try {
            // Deny all then add global accessible resources
            $authorization = $mvcAuthEvent->getAuthorizationService();

            // Deny from all
            $authorization->deny();
            $authorization->addResource('ApiSkeletons\OAuth2\Controller\Auth::token');
            $authorization->allow(null, 'ApiSkeletons\OAuth2\Controller\Auth::token');

            // Add resources and permissions
            $authorization->addResource('TestApi\V1\Rest\Role\Controller::collection');
            $authorization->allow('notallowed', 'TestApi\V1\Rest\Role\Controller::collection', 'GET');
        } catch (\Exception $e) {
            // ok to try to add again
        }
    }
}
