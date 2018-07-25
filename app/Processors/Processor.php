<?php

namespace Vas\Processors;

use Illuminate\Log\Logger;
use Illuminate\Support\Str;
use Vas\ReceivedMessage;

abstract class Processor
{
    protected $successor;

    /** @var Logger */
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(ReceivedMessage $message)
    {
        if ($this->isHandleable($message)) {
            return $this->handle($message);
        }

        return $this->getSuccessor()($message);
    }

    public abstract function isHandleable(ReceivedMessage $message): bool;

    public abstract function handle(ReceivedMessage $message): string;

    /**
     * @return Processor
     */
    public function getSuccessor(): Processor
    {
        return $this->successor;
    }

    /**
     * @param Processor $successor
     *
     * @return Processor
     */
    public function setSuccessor(Processor $successor): Processor
    {
        $this->successor = $successor;

        return $this;
    }

    /**
     * @return Logger
     */
    public function getLogger(): Logger
    {
        return $this->logger;
    }

    protected function trimThenUpper(string $message): string
    {
        return Str::upper(trim($message));
    }

}
