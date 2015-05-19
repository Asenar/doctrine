<?php

namespace Kohana\Doctrine;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Exception;
use Kohana;

/**
 * Class Config
 * @package Kohana\Doctrine
 */
class Config
{
    /**
     * Create a \Doctrine\ORM\Configuration based on the settings given.
     * If no settings are given the method will try to get the settings from the configuration file.
     *
     * @static
     * @access public
     * @param array $settings
     * @return \Doctrine\ORM\Configuration
     * @throws Exception
     */
    public static function instance($settings = null)
    {
        if (is_null($settings)) {
            // Get settings from configuration file
            $settings = self::getSettings();
        }

        // Get cache settings
        $cache = Cache::instance($settings->cache);
        $driverChain = new \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;

        // Get mapping type
        switch($settings->mapping['type']) {
            case 'xml':
                // Create xml mapping
                $config = Setup::createXMLMetadataConfiguration(
                    $settings->mapping["path"],
                    $settings->production,
                    $settings["proxy"]["path"],
                    $cache
                );
                foreach ($settings->namespaces as $namespace => $path) {
                    $driverChain->addDriver($config->getMetadataDriverImpl(), $namespace);
                }
                break;
            case 'annotation':
                // Generate annotation mapping
                $config = Setup::createAnnotationMetadataConfiguration(
                    $settings->mapping["path"],
                    $settings->production,
                    $settings["proxy"]["path"],
                    $cache
                );
                foreach ($settings->namespaces as $namespace) {
                    $driverChain->addDriver($config->getMetadataDriverImpl(), $namespace);
                }
                break;
            case 'yaml':
                // Generate yaml mapping
                $config = Setup::createYAMLMetadataConfiguration(
                    $settings->mapping["path"],
                    $settings->production,
                    $settings["proxy"]["path"],
                    $cache
                );
                foreach ($settings->namespaces as $namespace) {
                    $driverChain->addDriver($config->getMetadataDriverImpl(), $namespace);
                }
                break;
            default:
                throw new Exception('Mapping type not found');
        }

        $config->setMetadataDriverImpl($driverChain);

        // Implement maximum caching
        $config->setMetadataCacheImpl($cache);
        $config->setHydrationCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        $config->setResultCacheImpl($cache);

        // Set proxies and proxie-prefix
        $config->setProxyNamespace($settings->proxy["namespace"]);
        $config->setAutoGenerateProxyClasses($settings->proxy["generate"]);

        // Return result
        return $config;
    }

    /**
     * Get settings from configuration file
     *
     * @static
     * @access private
     * @return object
     */
    private static function getSettings()
    {
        return Kohana::$config->load('doctrine');
    }
}
