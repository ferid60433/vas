<?php

namespace Vas\Exceptions;

use RuntimeException;

class ShouldntBeCalledException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("Oops, Some thing goes wrong. This shouldn't be happening!");
    }
}
