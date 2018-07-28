<?php

namespace Tests\Unit\Processors;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Vas\Processors\DefaultProcessor;
use Vas\Processors\NullProcessor;
use Vas\Processors\Processor;
use Vas\ReceivedMessage;

class NullProcessorTest extends TestCase
{
    use WithFaker;

    /** @var Processor */
    protected $processor;

    public function randomMessage()
    {
        return array_fill(0, 3, [new ReceivedMessage()]);
    }

    /**
     * @dataProvider randomMessage
     * @param ReceivedMessage $message
     */
    public function testReturnTrue(ReceivedMessage $message)
    {
        $this->assertTrue($this->processor->isHandleable($message));
    }

    /**
     * @dataProvider randomMessage
     * @param ReceivedMessage $message
     */
    public function testReturnNull(ReceivedMessage $message)
    {
        $this->assertEquals('<null>', $this->processor->handle($message));
    }

    /**
     * @dataProvider randomMessage
     * @param ReceivedMessage $message
     * @expectedException \Vas\Exceptions\ShouldntBeCalledException
     */
    public function testGetSuccessorThrowsException(ReceivedMessage $message)
    {
        $this->processor->getSuccessor($message);
    }

    /**
     * @dataProvider randomMessage
     * @param ReceivedMessage $message
     * @expectedException \Vas\Exceptions\ShouldntBeCalledException
     */
    public function testSetSuccessorThrowsException(ReceivedMessage $message)
    {
        $this->processor->setSuccessor(app(DefaultProcessor::class));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->processor = app(NullProcessor::class);
    }

}
