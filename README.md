Kohana Doctrine Library
=======================

[![Build Status](https://travis-ci.org/kohana/doctrine.svg?branch=master)](https://travis-ci.org/kohana/doctrine)

The doctrine library for Kohana 3 provides a simple integration with doctrine 2.*. You can configure your doctrine
integration by placing the `config/doctrine.php` file into your `app/config` folder and editing it.

Supported mapping solutions
---------------------------

Currently this module supports the following mapping methods.

1. Annotation
2. Xml
3. Yaml

Supported caching solutions
---------------------------

Currently this module supports the following caching methods.

1. Apc
2. Array
3. Memcache
4. Redis
5. Xcache

Using Doctrine
--------------

To use Kohana Doctrine, install it by composer require. You can do this by running `composer require kohana/doctrine` in your CLI.
Then add Kohana Doctrine to your modules in `bootstrap.php` by adding the following line `'doctrine' => VENDORPATH.'kohana/doctrine'`.

To configure doctrine copy the `vendor/kohana/doctrine/config/doctrine.php` or your `app/config` folder and editing it.

Quick example
-------------

The following is a quick example of how to use Kohana Doctrine by getting the entity manager and getting a repository
from the entity manager.

    $entityManager = \Kohana\Doctrine\EntityManager::instance();
    $entityManager->getRepository('Full\Namespace\To\Entity')
