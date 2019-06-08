<?php

namespace App\Models\Data;

Class EmailData extends ArrayData
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject', 'from', 'fromName', 'to', 'toName', 'content', 'contentType'
    ];
}
