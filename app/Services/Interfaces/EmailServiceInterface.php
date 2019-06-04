<?php

namespace App\Services\Interfaces;

/**
 * Interface EmailServiceInterface
 * @package App\Services\Interfaces
 */
interface EmailServiceInterface
{

    /**
     * @param string $sid Request service Id
     * @param array $attributes Email sending data
     *
     * @return mixed
     */
    public function send($sid, array $attributes);
}
