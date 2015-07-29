<?php

namespace Kohana\Doctrine\Tests;

use Kohana\Doctrine\Driver;
use Mockery;

class DriverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mockery\Mock|\Kohana\Doctrine\Configuration
     */
    private $configuration;

    /**
     * @var \Kohana\Doctrine\Driver
     */
    private $driver;

    public function setUp()
    {
        $this->configuration = Mockery::mock('Kohana\Doctrine\Configuration');
        $this->driver = new Driver($this->configuration);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenNoMappingPath()
    {
        $this->setExpectedException('Kohana\Doctrine\Exception\IncorrectConfigurationException');

        $this->configuration->shouldReceive('get')
            ->with('mapping')
            ->andReturn([
                'type' => 'annotation',
                'path' => []
            ]);

        $this->configuration->shouldReceive('get')
            ->with('proxy')
            ->andReturn(['path' => 'path/to/proxy/files']);

        $this->configuration->shouldReceive('get')
            ->with('onProduction')
            ->andReturn(true);

        $this->driver->configureDriver();
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenNoProxyPath()
    {
        $this->setExpectedException('Kohana\Doctrine\Exception\IncorrectConfigurationException');

        $this->configuration->shouldReceive('get')
            ->with('mapping')
            ->andReturn([
                'type' => 'annotation',
                'path' => [
                    'path/to/mapping/files'
                ]
            ]);

        $this->configuration->shouldReceive('get')
            ->with('proxy')
            ->andReturn(['path' => '']);

        $this->configuration->shouldReceive('get')
            ->with('onProduction')
            ->andReturn(true);

        $this->driver->configureDriver();
    }

    /**
     * @test
     */
    public function shouldConfigureAnnotationDriver()
    {
        $this->configuration->shouldReceive('get')
            ->with('mapping')
            ->andReturn([
                'type' => 'annotation',
                'path' => [
                    'path/to/mapping/files'
                ]
            ]);

        $this->configuration->shouldReceive('get')
            ->with('proxy')
            ->andReturn(['path' => 'path/to/proxy/files']);

        $this->configuration->shouldReceive('get')
            ->with('onProduction')
            ->andReturn(true);

        $configuredDriver = $this->driver->configureDriver();
        $metadataDriver = $configuredDriver->getMetadataDriverImpl();

        $this->assertInstanceOf('Doctrine\ORM\Mapping\Driver\AnnotationDriver', $metadataDriver);
        $this->assertEquals(['path/to/mapping/files'], $metadataDriver->getPaths());
    }

    /**
     * @test
     */
    public function shouldConfigureXmlDriver()
    {
        $this->configuration->shouldReceive('get')
            ->with('mapping')
            ->andReturn([
                'type' => 'xml',
                'path' => [
                    'path/to/mapping/files'
                ]
            ]);

        $this->configuration->shouldReceive('get')
            ->with('proxy')
            ->andReturn(['path' => 'path/to/proxy/files']);

        $this->configuration->shouldReceive('get')
            ->with('onProduction')
            ->andReturn(true);

        $configuredDriver = $this->driver->configureDriver();
        $metadataDriver = $configuredDriver->getMetadataDriverImpl();

        $this->assertInstanceOf('Doctrine\ORM\Mapping\Driver\XmlDriver', $metadataDriver);
        $this->assertInstanceOf(
            'Doctrine\Common\Persistence\Mapping\Driver\DefaultFileLocator',
            $metadataDriver->getLocator()
        );
    }

    /**
     * @test
     */
    public function shouldConfigureYamlDriver()
    {
        $this->configuration->shouldReceive('get')
            ->with('mapping')
            ->andReturn([
                'type' => 'yaml',
                'path' => [
                    'path/to/mapping/files'
                ]
            ]);

        $this->configuration->shouldReceive('get')
            ->with('proxy')
            ->andReturn(['path' => 'path/to/proxy/files']);

        $this->configuration->shouldReceive('get')
            ->with('onProduction')
            ->andReturn(true);

        $configuredDriver = $this->driver->configureDriver();
        $metadataDriver = $configuredDriver->getMetadataDriverImpl();

        $this->assertInstanceOf('Doctrine\ORM\Mapping\Driver\YamlDriver', $metadataDriver);
        $this->assertInstanceOf(
            'Doctrine\Common\Persistence\Mapping\Driver\DefaultFileLocator',
            $metadataDriver->getLocator()
        );
    }
}
