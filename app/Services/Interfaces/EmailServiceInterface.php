<?php

namespace App\Services\Interfaces;

/**
 * Interface EmailServiceInterface
 * @package App\Services\Interfaces
 */
interface EmailServiceInterface
{

    /**
     * Get an array of attributes and create a record in emails table
     *
     * @param array $attributes
     *
     * @return array
     */
    public function create(array $attributes);

    /**
     * @param string $sid Request service Id
     * @param array $attributes Email sending data
     *
     * @return mixed
     */
    public function send($sid, array $attributes);
}
