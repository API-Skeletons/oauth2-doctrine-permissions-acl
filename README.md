This provides ACL (and RBAC) for zf-oauth2-doctrine

![Entity Relationship Diagram](https://raw.githubusercontent.com/API-Skeletons/zf-oauth2-doctrine-permissions/master/media/erd.png)

Entity Relationship Diagram created with [Skipper](https://skipper18.com)

Add ACL to your application in Module.php
```php
    public function onBootstrap(MvcEvent $e)
    {
        if ($e->getRequest() instanceof ConsoleRequest) {
            return;
        }

        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $serviceManager = $e->getApplication()->getServiceManager();

        // Configure ACL
        $authorizationListener = $serviceManager->get(Authorization\AuthorizationListener::class);
        $eventManager->attach(
            MvcAuthEvent::EVENT_AUTHORIZATION,
            $authorizationListener,
            100
        );
    }
```
