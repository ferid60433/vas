<?php

namespace Tests\Unit\Util;

use Symfony\Component\VarDumper\VarDumper;
use Tests\TestCase;
use Vas\Util\GsmEncoding;

class GsmEncodingTest extends TestCase
{

    public function rawData()
    {
        return [
            ['', true],
            ['Plain ASCII ¿', true],
            ['Plain ASCII with Extended "\\" charset', true],

            ['UCS-2 ዩቲፍ-8!', false],
            ['UCS-2 with emoji 🎊', false],
        ];
    }

    /**
     * @param $message
     * @param $assert
     *
     * @dataProvider rawData
     */
    public function testIsAscii($message, $assert)
    {
        $this->assertEquals($assert, GsmEncoding::isGsm0338($message));
    }

}
