OAuth2 Doctrine Permissions ACL
-------------------------------

[![Build Status](https://travis-ci.org/API-Skeletons/zf-oauth2-doctrine-permissions-acl.svg)](https://travis-ci.org/API-Skeletons/zf-oauth2-doctrine-permissions-acl)
[![Total Downloads](https://poser.pugx.org/api-skeletons/zf-oauth2-doctrine-permissions-acl/downloads)](https://packagist.org/packages/api-skeletons/zf-oauth2-doctrine-permissions-acl)

About
-----

This provides ACL for zf-oauth2-doctrine.  This replaces some components of zf-mvc-auth to enable multiple roles per user and auto injecting roles into the ACL.

This library is specifically for a many to many relationship between Role and User.  If you have a one to many relationship where each user may have only one role this library is not for you.

![Entity Relationship Diagram](https://raw.githubusercontent.com/API-Skeletons/zf-oauth2-doctrine-permissions/master/media/erd.png)

Entity Relationship Diagram created with [Skipper](https://skipper18.com)


Installation
------------
Installation of this module uses composer. For composer documentation, please refer to [getcomposer.org](http://getcomposer.org/).

```sh
$ php composer.phar require api-skeletons/zf-oauth2-doctrine-permissions-acl
```

If composer does not automatically add this, add to this module to your application's configuration:

```php
'modules' => array(
   ...
   'ZF\OAuth2\Doctrine\Permissions\Acl',
),
```

Copy config/oauth2.doctrine.permisisons.acl.global.php.dist to your application config/autoload/oauth2.doctrine.permisisons.acl.global.php

Authentication Identity
-----------------------

By default zf-mvc-auth reutrns an `ZF\MvcAuth\Identity\AuthenticatedIdentity` from zf-oauth2-doctrine when a user has a valid access token.  This repository replaces that identity with a `ZF\OAuth2\Doctrine\Permissions\Acl\Identity\AuthenticatedIdentity`.

`ZF\OAuth2\Doctrine\Permissions\Acl\Identity\AuthenticatedIdentity` stores the zf-oauth2-doctrine `AccessToken` Doctrine entity.  This entity has the functions `getUser`, `getAccessToken`, `getClient` which return entities.  With these your application can continue to work with ORM through the rest of the request lifecycle.

zf-oauth2-doctrine supports multiple OAuth2 configurations and zf-oauth2-doctrine-permissions-acl searches through each configuration
to find the `AccessToken` entity based on the `access_token` and `client_id` supplied by `ZF\MvcAuth\Identity\AuthenticatedIdentity`.


Role Related Interfaces
-----------------------

The ERD above shows the Doctrine relationship to a `Role` entity.  To fetch Roles for a user the User enitity must implement `ZF\OAuth2\Doctrine\Permissions\Acl\Role\ProviderInterface`.  The `Role` entity must implement `Zend\Permissions\Acl\Role\RoleInterface`.

Roles may have parents.  This is optional but the parent relationship is often important in ACL.  To create a role hierarcy your Role entity must implement `ZF\OAuth2\Doctrine\Permissions\Acl\Role\HierarchicalInterface`.  This interface also implements `Zend\Permissions\Acl\Role\RoleInterface`.


Adding Roles to the ACL
-----------------------

You may load all roles in your `Role` entity into the ACL by specifying this configuration in oauth2.doctrine.permisisons.acl.global.php
```php
'zf-oauth2-doctrine-permissions-acl' => [
    'role' => [
        'entity' => 'Db\Entity\Role',
        'object_manager' => 'doctrine.entitymanager.orm_default',
    ],
],
```
This will run at priority 1000 in the `MvcAuthEvent::EVENT_AUTHORIZATION` event.


`authorization` service manager override
----------------------------------------

The Authorization of zf-mvc-auth is overridden in this library.  This allows for one `User` to have multiple `Roles` and each
role to call the ACL with each request until a role is valid or no more user roles exist.


Adding your own resource guards
-------------------------------

With all of the above this library has set the stage to create permissions on your resources.
All your roles may be loaded and you can follow the official Apigility guide:
https://apigility.org/documentation/recipes/how-do-i-customize-authorization-for-a-particular-identity
Be sure your listener(s) run at priority < 1000.