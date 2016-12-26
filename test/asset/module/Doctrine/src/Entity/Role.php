<?php

namespace ZFTest\OAuth2\Doctrine\Permissions\Acl\Entity;

use ZF\OAuth2\Doctrine\Permissions\Acl\Role\HierarchicalInterface;

class Role implements
    HierarchicalInterface
{
    protected $id;
    protected $parent;
    protected $child;
    protected $roleId;
    protected $user;

    public function getUser()
    {
        return $this->user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setParent(Role $role)
    {
        $this->parent = $role;

        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getChild()
    {
        return $this->child;
    }

    public function setChild(Role $role)
    {
        $this->child = $role;

        return $this;
    }

    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

}