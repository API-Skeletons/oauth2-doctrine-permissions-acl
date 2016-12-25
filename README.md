
Add 

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
