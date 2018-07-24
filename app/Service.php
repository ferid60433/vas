<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'letter',
        'code',
        'confirmation_message',
    ];


    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(SentMessage::class);
    }

    public function scopeLetter($query, $letter)
    {
        return $query->where('letter', $letter);
    }

}
