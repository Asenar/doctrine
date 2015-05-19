<?php

namespace Kohana\Doctrine;

use Kohana;

/**
 * A model to load specific namespaces
 */
class DoctrineNamespace
{
    /**
     * Load all namespaces as defined in the configuration file
     *
     * @static
     * @access public
     * @return void
     */
    public function initialize()
    {
        foreach (self::getNamespaces() as $key => $value) {
            $classLoader = new \Doctrine\Common\ClassLoader($key, $value);
            $classLoader->register();
        }
    }

    /**
     * Get all namespaces from the configuration
     *
     * @static
     * @access private
     * @return array
     */
    private function getNamespaces()
    {
        return Kohana::$config->load('doctrine')->namespaces;
    }
}
