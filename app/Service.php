<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property string letter
 * @property string code
 * @property string confirmation_message
 */
class Service extends Model
{
    protected $fillable = [
        'letter',
        'code',
        'confirmation_message',
    ];

    public function setLetterAttribute($value)
    {
        $this->attributes['letter'] = Str::upper($value);
    }

    public static function lookupService(string $message): ?Service
    {
        $services = Service::all()->filter(function (Service $service) use ($message) {
            return Str::startsWith($message, $service->letter);
        });

        return $services->count() === 1 ? $services->first() : null;
    }

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
