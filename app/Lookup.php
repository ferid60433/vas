<?php

namespace Vas;

use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];
}
