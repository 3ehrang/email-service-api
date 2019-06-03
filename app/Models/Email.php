<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sid', 'status', 'data', 'receive_at',
    ];

    /**
     * Set the email's received at.
     *
     * @param  string  $value
     * @return void
     */
    public function setReceivedAtAttribute($value)
    {
        if (!$value) {
            $this->attributes['received_at'] = now();
        }
    }

    /**
     * Set the email's received at.
     *
     * @param  string  $value
     * @return void
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }
}
