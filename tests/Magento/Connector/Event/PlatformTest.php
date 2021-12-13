<?php

namespace BrontoTest\Magento\Connector\Event;

use Bronto\M2\Connector\Event\Platform;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Bronto\M2\Connector\Event\Platform
 */
class PlatformTest extends TestCase
{

    /**
     * @return array
     */
    public static function baseUrlProvider()
    {
        $defaultValue = Platform::SARLACC;

        return [
            [false, $defaultValue],
            ['', $defaultValue],
            ['     ', $defaultValue],
            ['0', $defaultValue],
            ['  0 ', $defaultValue],
            ['foo', 'foo'],
            [' bar ', 'bar'],
        ];
    }

    /**
     * @covers ::getBaseUrl
     * @dataProvider baseUrlProvider
     * @group unit
     *
     * @param string|false $envValue
     * @param string $expectedResult
     */
    public function testGetBaseUrl($envValue, $expectedResult)
    {
        $platform = \Mockery::mock(Platform::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $platform->shouldReceive('getEnvironmentVar')
            ->andReturn($envValue);

        self::assertEquals($expectedResult, $platform->getBaseUrl());
    }
}
