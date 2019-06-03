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
    function create(array $attributes)
    {
        $email = Email::create($attributes);
        return $email->toArray();
    }

    public function setAsSent($sid)
    {
        $update = ['status' => 2];

        return Email::where('sid', $sid)->update($update);
    }

    public function setAsFailed($sid)
    {
        $update = ['status' => 3];

        return Email::where('sid', $sid)->update($update);
    }
}
