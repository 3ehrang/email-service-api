<?php

namespace App\Repositories\Interfaces;

interface EmailRepoInterface
{
    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes);
}
