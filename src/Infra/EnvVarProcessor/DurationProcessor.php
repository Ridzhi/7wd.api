<?php

namespace App\Infra\EnvVarProcessor;

use Carbon\CarbonInterval;
use Closure;
use Symfony\Component\DependencyInjection\EnvVarProcessorInterface;

class DurationProcessor implements EnvVarProcessorInterface
{
    /**
     * @inheritDoc
     */
    public function getEnv(string $prefix, string $name, Closure $getEnv): mixed
    {
        return CarbonInterval::createFromDateString($getEnv($name));
    }

    /**
     * @inheritDoc
     */
    public static function getProvidedTypes(): array
    {
        return [
            'duration' => 'string',
        ];
    }
}
