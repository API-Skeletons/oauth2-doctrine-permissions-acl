<?php

namespace ZF\OAuth2\Doctrine\Permissions;

use Zend\Mvc\ModuleRouteListener;
use ZF\MvcAuth\MvcAuthEvent;
use Zend\Mvc\MvcEvent;
use Zend\Console\Request as ConsoleRequest;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function onBootstrap(MvcEvent $e)
    {
        // Bypass Permissions for console routes
        if ($e->getRequest() instanceof ConsoleRequest) {
            return;
        }

        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $serviceManager = $e->getApplication()->getServiceManager();

        // Attach an event to replace the Identity with a DoctrineAuthenticatedIdentity
        $authenticationPostListener = $serviceManager->get(Authentication\AuthenticationPostListener::class);
        $eventManager->attach(
            MvcAuthEvent::EVENT_AUTHENTICATION_POST,
            $authenticationPostListener,
            100
        );
    }
}
