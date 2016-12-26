<?php
return [
    'router' => [
        'routes' => [
            'test-api.rest.doctrine.role' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/role[/:role_id]',
                    'defaults' => [
                        'controller' => 'TestApi\\V1\\Rest\\Role\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'test-api.rest.doctrine.role',
        ],
    ],
    'zf-rest' => [
        'TestApi\\V1\\Rest\\Role\\Controller' => [
            'listener' => \TestApi\V1\Rest\Role\RoleResource::class,
            'route_name' => 'test-api.rest.doctrine.role',
            'route_identifier_name' => 'role_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'role',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ZFTest\OAuth2\Doctrine\Permissions\Acl\Entity\Role::class,
            'collection_class' => \TestApi\V1\Rest\Role\RoleCollection::class,
            'service_name' => 'Role',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'TestApi\\V1\\Rest\\Role\\Controller' => 'HalJson',
        ],
        'accept-whitelist' => [
            'TestApi\\V1\\Rest\\Role\\Controller' => [
                0 => 'application/vnd.test-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content-type-whitelist' => [
            'TestApi\\V1\\Rest\\Role\\Controller' => [
                0 => 'application/vnd.test-api.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \ZFTest\OAuth2\Doctrine\Permissions\Acl\Entity\Role::class => [
                'route_identifier_name' => 'role_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'test-api.rest.doctrine.role',
                'hydrator' => 'TestApi\\V1\\Rest\\Role\\RoleHydrator',
            ],
            \TestApi\V1\Rest\Role\RoleCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'test-api.rest.doctrine.role',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-apigility' => [
        'doctrine-connected' => [
            \TestApi\V1\Rest\Role\RoleResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'TestApi\\V1\\Rest\\Role\\RoleHydrator',
            ],
        ],
    ],
    'doctrine-hydrator' => [
        'TestApi\\V1\\Rest\\Role\\RoleHydrator' => [
            'entity_class' => \ZFTest\OAuth2\Doctrine\Permissions\Acl\Entity\Role::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
    ],
    'zf-content-validation' => [
        'TestApi\\V1\\Rest\\Role\\Controller' => [
            'input_filter' => 'TestApi\\V1\\Rest\\Role\\Validator',
        ],
    ],
];
