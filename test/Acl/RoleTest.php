<?php

namespace ZFTest\OAuth2\Doctrine\Permissions\Acl;

use ZF\OAuth2\Doctrine\Permissions\Acl\Role\ObjectRepositoryProvider;
use Zend\Stdlib\Request;

class RoleTest extends AbstractTest
{
    /** @dataProvider provideStorage */
    public function testObjectRepositoryProvider()
    {
        $serviceManager = $this->getApplication()->getServiceManager();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');

        $request = $this->getRequest();
        $request->getHeaders()->addHeaderLine('Accept', 'application/json');

        $this->dispatch('/oauth');

        $authorization = $this->getApplication()->getServiceManager()->get('authorization');
        $this->assertEquals(
            [
                'guest',
                'Guest',
                'User',
                'Admin',
                'notallowed',
            ],
            $authorization->getRoles()
        );
    }
}
