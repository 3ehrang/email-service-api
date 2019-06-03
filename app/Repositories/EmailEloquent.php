<?php

namespace App\Repositories;

use App\Models\Email;
use App\Repositories\Interfaces\EmailRepoInterface;

/**
 * Class EloquentEmail
 * @package App\Repositories
 */
class EmailEloquent implements EmailRepoInterface
{
    /**
     * Create a record in emails table by getting array of attributes
     *
     * @param array $attributes
     *
     * @return Email
     */
    public function create(array $attributes)
    {
        return Email::create($attributes);
    }
}
