<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'letter',
        'code',
        'confirmation_message',
        'mandatory',
    ];

    protected $casts = [
        'mandatory' => 'boolean',
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

    public function scopeMandatory($query, $mandatory)
    {
        return $query->where('mandatory', $mandatory);
    }

}
