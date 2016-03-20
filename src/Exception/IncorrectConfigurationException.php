<?php

namespace Kohana\Doctrine\Exception;

use Exception;

class IncorrectConfigurationException extends Exception
{
    /**
     * @param string $field
     */
    public function __construct($field)
    {
        parent::__construct(sprintf(
            'The field "%s" was not configured correctly',
            $field
        ));
    }
}
