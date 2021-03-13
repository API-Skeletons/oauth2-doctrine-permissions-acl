<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @copyright Copyright (c) 2016 Tom H Anderson <tom.h.anderson@gmail.com>
 *     for api-skeletons/api-tools-oauth2-doctrine-permissions
 */

namespace ApiSkeletons\OAuth2\Doctrine\Permissions\Acl\Role;

use Doctrine\ORM\EntityRepository;
use Laminas\Permissions\Acl\Role\RoleInterface;
use ApiSkeletons\OAuth2\Doctrine\Permissions\Acl\Role;
use GianArb\Angry\Unclonable;
use GianArb\Angry\Unserializable;
use GianArb\Angry\Uninvokable;

class ObjectRepositoryProvider
{
    use Unclonable;
    use Unserializable;
    use Uninvokable;

    protected $objectRepository;

    public function __construct(EntityRepository $objectRepository = null)
    {
        $this->objectRepository = $objectRepository;
    }

    public function getRoles()
    {
        $roles = [];

        if (! $this->objectRepository) {
            return false;
        }
        $roles = $this->objectRepository->findAll();

        // Sort roles so any with parent roles are satisfied
        $sorted = [];
        while (sizeof($roles)) {
            foreach ($roles as $key => $role) {
                if (! $role instanceof RoleInterface) {
                    unset($roles[$key]);
                    continue;
                }

                if (! $role instanceof HierarchicalInterface
                    || ! $role->getParent()
                    || in_array($role->getParent(), $sorted)
                ) {
                    $sorted[] = $role;
                    unset($roles[$key]);
                    continue;
                }
            }
        }

        foreach ($sorted as $role) {
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

        return $roles;
    }
}
