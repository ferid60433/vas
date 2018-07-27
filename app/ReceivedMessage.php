<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ReceivedMessage extends Model
{
    protected $fillable = [
        'address',
        'message',
    ];

    public function getFullAddressAttribute()
    {
        return '2519'.$this->address;
    }

    public function setAddressAttribute($address)
    {
        $this->attributes['address'] = Str::substr(trim($address), -8);
    }

}
