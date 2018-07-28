<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Vas\SentMessage
 *
 * @property int $id
 * @property int|null $service_id
 * @property string $address
 * @property string $message
 * @property int $delivery_status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $full_address
 * @property-read \Vas\Service|null $service
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\SentMessage whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\SentMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\SentMessage whereDeliveryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\SentMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\SentMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\SentMessage whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\SentMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SentMessage extends Model
{
    protected $fillable = [
        'service_id',
        'address',
        'message',
        'delivery_status',
    ];

    protected $appends = ['full_address'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getFullAddressAttribute()
    {
        return '2519'.$this->address;
    }

    public function setAddressAttribute($address)
    {
        $this->attributes['address'] = Str::substr(trim($address), -8);
    }

}
