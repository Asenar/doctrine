<?php

namespace Kohana\Doctrine\Tests;

use Kohana\Doctrine\Cache;
use Mockery;

class CacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mockery\Mock|\Kohana\Doctrine\Configuration
     */
    private $configuration;

    /**
     * @var \Kohana\Doctrine\Cache
     */
    private $cache;

    public function setUp()
    {
        $this->configuration = Mockery::mock('Kohana\Doctrine\Configuration');
        $this->cache = new Cache($this->configuration);
    }

    /**
     * @test
     */
    public function shouldConfigureApcCache()
    {
        $this->configuration->shouldReceive('get')
            ->with('cache')
            ->andReturn(['type' => 'apc']);

        $configuredCache = $this->cache->configureCache();

        $this->assertInstanceOf('Doctrine\Common\Cache\ApcCache', $configuredCache);
    }

    /**
     * @test
     */
    public function shouldConfigureArrayCache()
    {
        $this->configuration->shouldReceive('get')
            ->with('cache')
            ->andReturn(['type' => 'array']);

        $configuredCache = $this->cache->configureCache();

        $this->assertInstanceOf('Doctrine\Common\Cache\ArrayCache', $configuredCache);
    }

    /**
     * @test
     */
    public function shouldConfigureMemcacheCache()
    {
        $this->configuration->shouldReceive('get')
            ->with('cache')
            ->andReturn(['type' => 'memcache', 'host' => 'localhost', 'port' => 1000]);

        $configuredCache = $this->cache->configureCache();

        $this->assertInstanceOf('Doctrine\Common\Cache\MemcacheCache', $configuredCache);
    }

    /**
     * @test
     */
    public function shouldConfigureRedisCache()
    {
        $this->configuration->shouldReceive('get')
            ->with('cache')
            ->andReturn(['type' => 'redis', 'host' => 'localhost', 'port' => 1000]);

        $configuredCache = $this->cache->configureCache();

        $this->assertInstanceOf('Doctrine\Common\Cache\RedisCache', $configuredCache);
    }

    /**
     * @test
     */
    public function shouldConfigureXcacheCache()
    {
        $this->configuration->shouldReceive('get')
            ->with('cache')
            ->andReturn(['type' => 'Xcache']);

        $configuredCache = $this->cache->configureCache();

        $this->assertInstanceOf('Doctrine\Common\Cache\XcacheCache', $configuredCache);
    }
}
