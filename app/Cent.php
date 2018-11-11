<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;

class Cent extends Model
{

    protected $fillable = ['received_message_id', 'response'];

    protected $casts = [
        'response' => 'array',
    ];

    public function message()
    {
        return $this->belongsTo(ReceivedMessage::class, 'received_message_id', 'id');
    }

}
