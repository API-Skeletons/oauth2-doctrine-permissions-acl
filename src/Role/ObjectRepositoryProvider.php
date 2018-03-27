<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @copyright Copyright (c) 2016 Tom H Anderson <tom.h.anderson@gmail.com>
 *     for api-skeletons/zf-oauth2-doctrine-permissions
 */

namespace ZF\OAuth2\Doctrine\Permissions\Acl\Role;

use Doctrine\Common\Persistence\ObjectRepository;
use Zend\Permissions\Acl\Role\RoleInterface;
use ZF\OAuth2\Doctrine\Permissions\Acl\Role;
use GianArb\Angry\Unclonable;
use GianArb\Angry\Unserializable;
use GianArb\Angry\Uninvokable;

class ObjectRepositoryProvider
{
    use Unclonable;
    use Unserializable;
    use Uninvokable;

    protected $objectRepository;

    public function __construct(ObjectRepository $objectRepository = null)
    {
        $this->objectRepository = $objectRepository;
    }

    public function getRoles()
    {
        $roles = [];

        if ($this->objectRepository) {
            foreach ($this->objectRepository->findAll() as $role) {
                if (! $role instanceof RoleInterface) {
                    continue;
                }

                $parents = [];
                if ($role instanceof Role\HierarchicalInterface) {
                    $parent = $role->getParent();
                    while ($parent) {
                        $parents[] = $parent->getRoleId();
                        $parent = $parent->getParent();
                    }
                }

                // ACL roles for parents read right to left.  These are built
                // left to right so reverse the array
                $roles[] = new Role\Role($role->getRoleId(), array_reverse($parents));
            }
        }

        return $roles;
    }
}
