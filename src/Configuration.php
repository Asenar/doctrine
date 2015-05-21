<?php

namespace Kohana\Doctrine;

use Kohana;
use Kohana_Config_Group;

class Configuration
{
    /**
     * @var Kohana_Config_Group
     */
    private $doctrineConfiguration;

    public function __construct()
    {
        $this->doctrineConfiguration = Kohana::$config->load('doctrine');
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->doctrineConfiguration->get($key);
    }
}
