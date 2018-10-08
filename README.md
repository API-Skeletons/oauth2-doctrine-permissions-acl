OAuth2 Doctrine Permissions ACL
-------------------------------

[![Build Status](https://travis-ci.org/API-Skeletons/zf-oauth2-doctrine-permissions-acl.svg)](https://travis-ci.org/API-Skeletons/zf-oauth2-doctrine-permissions-acl)
[![Gitter](https://badges.gitter.im/api-skeletons/open-source.svg)](https://gitter.im/api-skeletons/open-source)
[![Total Downloads](https://poser.pugx.org/api-skeletons/zf-oauth2-doctrine-permissions-acl/downloads)](https://packagist.org/packages/api-skeletons/zf-oauth2-doctrine-permissions-acl)


Versions
--------

1.x for PHP 5.5 to 7.0.  2.x for PHP 7.1 onward.


About
-----

This provides ACL for [api-skeletons/zf-oauth2-doctrine](https://github.com/API-Skeletons/zf-oauth2-doctrine).  This replaces some components of [zfcampus/zf-mvc-auth](https://github.com/zfcampus/zf-mvc-auth) to enable multiple roles per user and auto injecting roles into the ACL.

This library is specifically for a many to many relationship between Role and User.  If you have a one to many relationship where each user may have only one role this library is not for you.

This library depends on [api-skeletons/zf-oauth2-doctrine-identity](https://github.com/API-Skeletons/zf-oauth2-doctrine-identity).  Please see that library for implementation details.

![Entity Relationship Diagram](https://raw.githubusercontent.com/API-Skeletons/zf-oauth2-doctrine-permissions/master/media/erd.png)

Entity Relationship Diagram created with [Skipper](https://skipper18.com)


Installation
------------
Installation of this module uses composer. For composer documentation, please refer to [getcomposer.org](http://getcomposer.org/).

```sh
composer require api-skeletons/zf-oauth2-doctrine-permissions-acl
```

This will be added to your application's list of modules:

```php
'modules' => array(
   ...
   'ZF\OAuth2\Doctrine\Permissions\Acl',
),
```

Role Related Interfaces
-----------------------

The ERD above shows the Doctrine relationship to a `Role` entity.  To fetch Roles for a user the User enitity must implement [`ZF\OAuth2\Doctrine\Permissions\Acl\Role\ProviderInterface`](https://github.com/API-Skeletons/zf-oauth2-doctrine-permissions-acl/blob/master/src/Role/ProviderInterface.php).  The `Role` entity must implement [`Zend\Permissions\Acl\Role\RoleInterface`](https://github.com/zendframework/zend-permissions-acl/blob/master/src/Role/RoleInterface.php).

Roles may have parents.  This is optional but the parent relationship is often important in ACL.  To create a role hierarchy your Role entity must implement [`ZF\OAuth2\Doctrine\Permissions\Acl\Role\HierarchicalInterface`](https://github.com/API-Skeletons/zf-oauth2-doctrine-permissions-acl/blob/master/src/Role/HierarchicalInterface.php).  This interface also implements [`Zend\Permissions\Acl\Role\RoleInterface`](https://github.com/zendframework/zend-permissions-acl/blob/master/src/Role/RoleInterface.php).


Adding Roles to the ACL
-----------------------

To copy roles into the ACL from your Role entity copy [`config/oauth2.doctrine.permisisons.acl.global.php.dist`](https://github.com/API-Skeletons/zf-oauth2-doctrine-permissions-acl/blob/master/config/oauth2.doctrine.permisisons.global.php.dist) to your application `config/autoload/oauth2.doctrine.permisisons.acl.global.php`
```php
'zf-oauth2-doctrine-permissions-acl' => [
    'role' => [
        'entity' => 'Db\Entity\Role',
        'object_manager' => 'doctrine.entitymanager.orm_default',
    ],
],
```
This will run at priority 1000 in the `MvcAuthEvent::EVENT_AUTHORIZATION` event.  If you do not want to autoload roles remove the 'role' configuration entirely.


Adding Resource Guards
-------------------------------

With all of the above this library has set the stage to create permissions on your resources.
All your roles may be loaded and you can follow the official Apigility guide:
https://apigility.org/documentation/recipes/how-do-i-customize-authorization-for-a-particular-identity
Be sure your listener(s) run at priority < 1000.

This is a short summary of the linked article.

Add this bootstrap to your Module:
```php
namespace Application;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener;
use Application\Authorization\AuthorizationListener;
use ZF\MvcAuth\MvcAuthEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach(
            MvcAuthEvent::EVENT_AUTHORIZATION,
            new AuthorizationListener(),
            100 // Less than 1000 to allow roles to be added first && >= 100
        );
    }
}
```

Create your AuthorizationListener:
```php
namespace Application\Authorization;

use ZF\MvcAuth\MvcAuthEvent;
use Db\Fixture\RoleFixture;

class AuthorizationListener
{
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        $authorization = $mvcAuthEvent->getAuthorizationService();

        // Deny from all
        $authorization->deny();

        // Allow from all for oauth authentication
        $authorization->addResource('ZF\OAuth2\Controller\Auth::token');
        $authorization->allow(null, 'ZF\OAuth2\Controller\Auth::token');

        // Add application specific resources
        $authorization->addResource('FooBar\V1\Rest\Foo\Controller::collection');
        $authorization->allow(RoleFixture::USER, 'FooBar\V1\Rest\Foo\Controller::collection', 'GET');
    }
}
```


Overriding the IS_AUTHORIZED event
----------------------------------

An event manager on the AclAuthorization allows you to override any ACL call.  For instance if you have
another entity which requires permissions based in its value you can add new Roles to your ACL manually
then create an override when the authorization is checked to allow for those other entity values now
proxied as roles:

```
use ZF\OAuth2\Doctrine\Permissions\Acl\Event;
use Zend\EventManager\Event as MvcEvent;

// Allow membership as a role
$events = $serviceManager->get('SharedEventManager');
$events->attach(
    Event::class,
    Event::IS_AUTHORIZED,
    function(MvcEvent $event)
    {
        if (! $event->getParam('identity') instanceof AuthenticatedIdentity) {
            return;
        }

        $membership = $event->getParam('identity')->getUser()->getMembership();

        if ($event->getTarget()->isAllowed($membership->getName(), $event->getParam('resource'), $event->getParam('privilege'))) {
            $event->stopPropagation();

            return true;
        }
    },
    100
);

```
