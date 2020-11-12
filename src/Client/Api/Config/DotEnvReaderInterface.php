<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Api\Config;

interface DotEnvReaderInterface
{
    /**
     * Get environment values from directory with dot env file
     */
    public function getEnvValues(string $dotEnvDirPath): array;
}
