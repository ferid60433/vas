<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int id
 * @property string address
 * @property string message
 * @property string delivery_status
 */
class SentMessage extends Model
{
    protected $fillable = [
        'service_id',
        'address',
        'message',
        'delivery_status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getFullAddressAttribute($address)
    {
        return '2519'.$address;
    }

    public function setAddressAttribute($address)
    {
        $this->attributes['address'] = Str::substr(trim($address), -8);
    }

}
