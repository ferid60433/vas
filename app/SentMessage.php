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
 * @property string $delivery_status_string
 * @property string $delivery_status_color
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

    protected $appends = ['full_address', 'delivery_status_string', 'delivery_status_color'];

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

    public function getDeliveryStatusStringAttribute()
    {
        switch ($this->delivery_status) {
            case 0: return 'Pending';
            case 1: return 'Success';
            case 2: return 'Failed';
            case 4: return 'Buffered';
            case 8: return 'Submitted';
            case 16: return 'Rejected';

            default: return "[Status Code: {$this->delivery_status}]";
        }
    }

    public function getDeliveryStatusColorAttribute()
    {
        switch ($this->delivery_status) {
            case 1: return 'success';

            case 2:
            case 16: return 'danger';

            default: return 'info';
        }
    }

}
