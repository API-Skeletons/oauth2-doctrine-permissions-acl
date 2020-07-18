<?php

/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @copyright Copyright (c) 2016 Tom H Anderson <tom.h.anderson@gmail.com>
 *     for api-skeletons/api-tools-oauth2-doctrine-permissions
 */

namespace Laminas\ApiTools\OAuth2\Doctrine\Permissions\Acl\Role;

use Laminas\Permissions\Acl\Role\RoleInterface;

interface HierarchicalInterface extends RoleInterface
{
    public function getParent();
}
