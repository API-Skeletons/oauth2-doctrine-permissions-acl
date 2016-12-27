<?php

namespace ZF\OAuth2\Doctrine\Permissions\Acl\Role;

use Zend\Permissions\Acl\Role\GenericRole;
use GianArb\Angry\Uninvokable;

class Role extends GenericRole implements
    HierarchicalInterface
{
    use Uninvokable;

    public function __construct($roleId, array $parent = null)
    {
        $this->roleId = $roleId;
        $this->parent = $parent;
    }

    protected $parent;

    public function getParent()
    {
        return $this->parent;
    }
}
