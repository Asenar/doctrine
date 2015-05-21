<?php

namespace Kohana\Doctrine\Caching;

interface CacheInterface
{
    /**
     * @param array $cacheConfig
     * @return \Doctrine\Common\Cache\CacheProvider
     */
    public function configureCache(array $cacheConfig);
}
