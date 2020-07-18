<?php

namespace ApiSkeletons\OAuth2\Doctrine\Permissions\Acl;

class Event
{
    /**
     * Fired as soon as resolve is called.  Can override entire
     * resolve function.
     */
    const IS_AUTHORIZED = 'isAuthorized';
}
