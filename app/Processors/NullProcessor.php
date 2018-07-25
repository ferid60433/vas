<?php

namespace Vas\Processors;

use Vas\Exceptions\ShouldntBeCalledException;
use Vas\ReceivedMessage;

class NullProcessor extends Processor
{

    public function isHandleable(ReceivedMessage $message): bool
    {
        return true;
    }

    public function handle(ReceivedMessage $message): string
    {
        return '<null>';
    }

    public function getSuccessor(): Processor
    {
        throw new ShouldntBeCalledException();
    }

    public function setSuccessor(Processor $processor): Processor
    {
        throw new ShouldntBeCalledException();
    }

}
