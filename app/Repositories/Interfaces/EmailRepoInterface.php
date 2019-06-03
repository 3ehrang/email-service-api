<?php

namespace App\Repositories\Interfaces;

interface EmailRepoInterface
{
    /**
     * Create a record in emails table by getting array of attributes
     *
     * @param array $attributes
     *
     * @return array
     */
    public function create(array $attributes);

    /**
     * Update email's status to 2 where 'sid' equals $sid
     *
     * @param string $sid
     *
     * @return boolean
     */
    public function setAsSent($sid);

    /**
     * Update emails's status to 3 where 'sid' equals $sid
     *
     * @param       $sid
     *
     * @return boolean
     */
    public function setAsFailed($sid);
}
