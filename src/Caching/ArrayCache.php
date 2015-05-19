<?php

namespace Kohana\Doctrine\Caching;

class ArrayCache implements CacheInterface
{
    public function configureCache(array $cacheConfig)
    {
        return new \Doctrine\Common\Cache\ArrayCache;
    }
}
