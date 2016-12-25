<?php

/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @copyright Copyright (c) 2016 Tom H Anderson <tom.h.anderson@gmail.com> for api-skeletons/zf-oauth2-doctrine-permissions
 */

namespace ZF\OAuth2\Doctrine\Permissions\Role;

use Zend\Permissions\Acl\Role\RoleInterface;

interface HierarchicalRoleInterface extends RoleInterface
{
    public function getParent();
}