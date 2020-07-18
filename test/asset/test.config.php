<?php

$modules = [
    'Laminas\\Cache',
    'Laminas\\Form',
    'Laminas\\I18n',
    'Laminas\\Filter',
    'Laminas\\Hydrator',
    'Laminas\\InputFilter',
    'Laminas\\Paginator',
    'Laminas\\Router',
    'Laminas\\Validator',
    'Laminas\\ApiTools',
    'Laminas\\ApiTools\\ApiProblem',
//    'Laminas\\ApiTools\\Configuration',
    'Laminas\\ApiTools\\OAuth2',
    'Laminas\\ApiTools\\MvcAuth',
    'Laminas\\ApiTools\\Hal',
    'Laminas\\ApiTools\\ContentNegotiation',
    'Laminas\\ApiTools\\ContentValidation',
    'Laminas\\ApiTools\\Rest',
    'Laminas\\ApiTools\\Rpc',
    'Laminas\\ApiTools\\Versioning',
    'Phpro\\DoctrineHydrationModule',
    'Laminas\\ApiTools\\Doctrine\\Server',
    'ApiSkeletons\\OAuth2\\Doctrine',
    'ApiSkeletons\\OAuth2\\Doctrine\\Identity',
    'ApiSkeletons\\OAuth2\\Doctrine\\Permissions\\Acl',
    'ApiSkeletonsTest\\OAuth2\\Doctrine\\Permissions\\Acl',
    'DoctrineModule',
    'DoctrineORMModule',
    'TestApi',
];

if (class_exists(Laminas\Router\Module::class)) {
    $modules[] = 'Laminas\\Router';
}

return [
    // This should be an array of module namespaces used in the application.
    'modules' => $modules,

    // These are various options for the listeners attached to the ModuleManager
    'module_listener_options' => [
        // This should be an array of paths in which modules reside.
        // If a string key is provided, the listener will consider that a module
        // namespace, the value of that key the specific path to that module's
        // Module class.
        'module_paths' => [
            __DIR__ . '/../../vendor',
            __DIR__ . '/module',
            'ApiSkeletonsTest\\OAuth2\\Doctrine\\Permissions\\Acl' => __DIR__ . '/module/Doctrine',
            'TestApi' => __DIR__ . '/module/TestApi',
        ],

        // An array of paths from which to glob configuration files after
        // modules are loaded. These effectively override configuration
        // provided by modules themselves. Paths may use GLOB_BRACE notation.
        'config_glob_paths' => [
            __DIR__ . '/autoload/{,*.}{global,local}.php',
        ],

    ],
];
