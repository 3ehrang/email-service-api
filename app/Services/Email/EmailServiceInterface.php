<?php

namespace App\Services\Email;

use App\Models\Data\EmailData;

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
     * @param EmailData $emailData Email sending data
     *
     * @return mixed
     */
    public function send($sid, EmailData $emailData);
}
