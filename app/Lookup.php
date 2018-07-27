<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;

/**
 * Vas\Lookup
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Lookup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Lookup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Lookup whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Lookup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vas\Lookup whereValue($value)
 * @mixin \Eloquent
 */
class Lookup extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];
}
