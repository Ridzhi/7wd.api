<?php

namespace App\Tests\Infra\EnvVarProcessor;

use App\Infra\EnvVarProcessor\DurationProcessor;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Infra\EnvVarProcessor\DurationProcessor
 */
class DurationProcessorTest extends TestCase
{
    /**
     * @covers ::getEnv
     * @dataProvider getEnvProvider
     */
    public function testGetEnv(string $env, string $value, int $expected): void
    {
        $getter = function (string $name) use ($value): string {
            return $value;
        };

        $this->assertEquals(
            $expected,
            (new DurationProcessor())->getEnv('SWD', $env, $getter)->totalSeconds,
        );
    }

    /**
     * @return array[]
     */
    public function getEnvProvider(): array
    {
        $env = function (string $name): string {
            $name = strtoupper($name);
            return "SWD_TTL_$name";
        };

        return [
            'second' => [
                $env('second'),
                '1 second',
                1,
            ],
            'seconds' => [
                $env('seconds'),
                '10 second',
                10,
            ],
            'minute' => [
                $env('minute'),
                '1 minute',
                60,
            ],
            'minutes' => [
                $env('minutes'),
                '10 minutes',
                600,
            ],
            'hour' => [
                $env('hour'),
                '1 hour',
                3600,
            ],
            'hours' => [
                $env('hours'),
                '10 hours',
                36000,
            ],
            'day' => [
                $env('day'),
                '1 day',
                86400,
            ],
            'days' => [
                $env('days'),
                '10 days',
                864000,
            ],
            'mix' => [
                $env('mix'),
                '2 days 2 hours 1 minutes 5 seconds',
                172800 + 7200 + 60 + 5,
            ],
            'mix_not_ordered' => [
                $env('mix_not_ordered'),
                '5 seconds 1 minutes',
                60 + 5,
            ]
        ];
    }
}
