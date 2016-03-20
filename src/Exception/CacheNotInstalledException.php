<?php

namespace Kohana\Doctrine\Exception;

use Exception;

class CacheNotInstalledException extends Exception
{
    /**
     * @param string $cacheName
     */
    public function __construct($cacheName)
    {
        parent::__construct(sprintf(
            'Cache named "%s" is not installed properly',
            $cacheName
        ));
    }
}
