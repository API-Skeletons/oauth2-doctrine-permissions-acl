<?php

namespace Laminas\ApiTools\OAuth2\Doctrine\Permissions\Acl\Role;

use Laminas\Permissions\Acl\Role\GenericRole;
use GianArb\Angry\Uninvokable;

class Role extends GenericRole implements
    HierarchicalInterface
{
    use Uninvokable;

    protected $parent;

    public function __construct($roleId, array $parent = null)
    {
        parent::__construct($roleId);

        $this->roleId = $roleId;
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }
}
