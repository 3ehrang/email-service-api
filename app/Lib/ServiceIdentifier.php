<?php

namespace App\Lib;

/**
 * Class ServiceIdentifier creates a unique service identifier
 *
 * @package App\Services
 */
class ServiceIdentifier
{
    /**
     * Create a unique service identifier and return value
     *
     * @return string
     */
    public static function Create()
    {
        $prefix = 'sid-';

        return uniqid($prefix);
    }
}
