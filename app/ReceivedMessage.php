<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;

class ReceivedMessage extends Model
{
    protected $fillable = [
        'address',
        'message',
    ];
}
