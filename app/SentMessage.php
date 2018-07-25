<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;

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

}