<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Vas\Service
 *
 * @property int $id
 * @property string $letter
 * @property string $code
 * @property string $confirmation_message
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Vas\SentMessage[] $sentMessages
 * @property-read \Illuminate\Database\Eloquent\Collection|\Vas\Subscriber[] $subscribers
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Service letter($letter)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Service whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Service whereConfirmationMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Service whereLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Service whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Service extends Model
{
    protected $fillable = [
        'letter',
        'code',
        'confirmation_message',
    ];

    public static function lookupService(string $message): ?Service
    {
        $message = Str::upper($message);

        return Service::with('subscribers')->get()
            ->filter(function ($service) use ($message) {
                return Str::startsWith($message, $service->letter);
            })
            ->first();
    }

    public function setLetterAttribute($value)
    {
        $this->attributes['letter'] = Str::upper($value);
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
