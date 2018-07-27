<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
