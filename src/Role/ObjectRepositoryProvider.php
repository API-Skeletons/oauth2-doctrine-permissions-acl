<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @copyright Copyright (c) 2016 Tom H Anderson <tom.h.anderson@gmail.com> for api-skeletons/zf-oauth2-doctrine-permissions
 */

namespace ZF\OAuth2\Doctrine\Permissions\Acl\Role;

use Acl\Role\Role;
use Acl\Role\HierarchicalRoleInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Zend\Permissions\Acl\Role\RoleInterface;

class ObjectRepositoryProvider
{
    protected $objectRepository;

    public function __construct(ObjectRepository $objectRepository)
    {
        $this->objectRepository = $objectRepository;
    }

    public function getRoles()
    {
        $roles = [];
        foreach ($this->objectRepository->findAll() as $role) {
            if (! $role instanceof RoleInterface) {
                continue;
            }

            $parents = [];
            if ($role instanceof HierarchicalRoleInterface) {
                $parent = $role->getParent();
                while ($parent) {
                    $parents[] = $parent->getRoleId();
                    $parent = $parent->getParent();
                }
            }

            $roles[] = new Role($role->getRoleId(), $parents);
        }

        return $roles;
    }
}