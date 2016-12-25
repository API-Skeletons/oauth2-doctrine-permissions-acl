<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright Copyright (c) 2016 Tom H Anderson <tom.h.anderson@gmail.com> for api-skeletons/zf-oauth2-doctrine-permissions
 */

namespace ZF\OAuth2\Doctrine\Permissions\Authorization;

use Zend\Permissions\Acl\Acl;
use ZF\MvcAuth\Identity\IdentityInterface;
use ZF\MvcAuth\Authorization\AuthorizationInterface;
use ZF\OAuth2\Doctrine\Permissions\Identity\AuthenticatedIdentity;

class AclAuthorization extends Acl implements AuthorizationInterface
{
    public function isAuthorized(IdentityInterface $identity, $resource, $privilege)
    {

        if (null !== $resource && (! $this->hasResource($resource))) {
            $this->addResource($resource);
        }

        if ($identity instanceof AuthenticatedIdentity) {
            foreach ($identity->getUser()->getRole() as $role) {
                if ($this->isAllowed($role->getRoleId(), $resource, $privilege)) {
                    return true;
                }
            }
        } else {
            if (! $this->hasRole($identity)) {
                $this->addRole($identity);
            }

            return $this->isAllowed($identity, $resource, $privilege);
        }

        return false;
    }
}
