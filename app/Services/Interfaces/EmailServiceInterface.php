<?php

namespace App\Services\Interfaces;

/**
 * Interface EmailServiceInterface
 * @package App\Services\Interfaces
 */
interface EmailServiceInterface
{

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function send(array $attributes);
}
