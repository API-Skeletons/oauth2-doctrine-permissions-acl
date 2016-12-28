<?php

namespace ZF\OAuth2\Doctrine\Permissions\Acl;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\Mvc\ModuleRouteListener;
use ZF\MvcAuth\MvcAuthEvent;
use Zend\Mvc\MvcEvent;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    DependencyIndicatorInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $serviceManager = $e->getApplication()->getServiceManager();

        // Add all ACL roles
        $authorizationListener = $serviceManager->get(Authorization\AuthorizationListener::class);
        $eventManager->attach(
            MvcAuthEvent::EVENT_AUTHORIZATION,
            $authorizationListener,
            1000
        );
    }

    public function getModuleDependencies()
    {
        return array('ZF\OAuth2\Doctrine\Identity');
    }
}
