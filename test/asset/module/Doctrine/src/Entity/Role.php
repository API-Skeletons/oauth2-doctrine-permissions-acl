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

    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
        $this->child = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \Db\Entity\User $user
     *
     * @return Role
     */
    public function addUser(\ZFTest\OAuth2\Doctrine\Permissions\Acl\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Db\Entity\User $user
     */
    public function removeUser(\ZFTest\OAuth2\Doctrine\Permissions\Acl\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
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
