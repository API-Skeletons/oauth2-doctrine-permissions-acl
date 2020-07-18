<?php

namespace ApiSkeletons\OAuth2\Doctrine\Permissions\Acl;

use Laminas\ModuleManager\Feature\AutoloaderProviderInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\DependencyIndicatorInterface;
use Laminas\Mvc\ModuleRouteListener;
use Laminas\ApiTools\MvcAuth\MvcAuthEvent;
use Laminas\Mvc\MvcEvent;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    DependencyIndicatorInterface
{
    /**
     * Provide default configuration.
     *
     * @return array
     */
    public function getConfig()
    {
        $provider = new ConfigProvider();

        return [
            'service_manager' => $provider->getDependencyConfig(),
        ];
    }

    public function getAutoloaderConfig()
    {
        return [
            'Laminas\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
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
        return ['ApiSkeletons\OAuth2\Doctrine\Identity'];
    }
}
