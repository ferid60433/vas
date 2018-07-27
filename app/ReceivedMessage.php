<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Vas\ReceivedMessage
 *
 * @property int $id
 * @property string $address
 * @property string $message
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $full_address
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\ReceivedMessage whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\ReceivedMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\ReceivedMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\ReceivedMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\ReceivedMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
