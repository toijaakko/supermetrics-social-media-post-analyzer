<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Model\Config;

use SuperMetrics\Client\Api\Config\DotEnvReaderInterface;
use SuperMetrics\Client\Exception\ConfigurationException;

class DotEnvReader implements DotEnvReaderInterface
{
    private array $envData;

    public function getEnvValues(string $dotEnvDirPath): array
    {
        if (!isset($this->envData)) {
            try {
                $this->envData = \Dotenv\Dotenv::createImmutable($dotEnvDirPath)->load();
            } catch (\Exception $exception) {
                throw new ConfigurationException(\sprintf('Invalid environment file path \'%s\'.env', $dotEnvDirPath));
            }
        }

        return $this->envData;
    }
}
