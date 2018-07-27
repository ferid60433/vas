<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Vas\Subscriber
 *
 * @property int $id
 * @property int $service_id
 * @property string $address
 * @property \Carbon\Carbon|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $full_address
 * @property-read \Vas\Service $service
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Vas\Subscriber onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Subscriber whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Subscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Subscriber whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Subscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Subscriber whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Subscriber whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Vas\Subscriber withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Vas\Subscriber withoutTrashed()
 * @mixin \Eloquent
 */
class Subscriber extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'service_id',
        'address',
        'deleted_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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
