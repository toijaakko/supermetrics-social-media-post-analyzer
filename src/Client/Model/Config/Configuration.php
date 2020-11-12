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

use SuperMetrics\Client\Api\Config\ConfigurationInterface;
use SuperMetrics\Client\Api\Config\DotEnvReaderInterface;
use SuperMetrics\Client\Exception\ConfigurationException;

class Configuration implements ConfigurationInterface
{
    private array $envData;

    private DotEnvReaderInterface $dotEnvReader;

    /**
     * Configuration constructor.
     */
    public function __construct(
        DotEnvReaderInterface $dotEnvReader
    ) {
        $this->dotEnvReader = $dotEnvReader;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenUrl(): string
    {
        return $this->getValue(self::ENV_TOKEN_URL);
    }

    /**
     * {@inheritdoc}
     */
    public function getPostsUrl(): string
    {
        return $this->getValue(self::ENV_POSTS_URL);
    }

    /**
     * {@inheritdoc}
     */
    public function getClientId(): string
    {
        return $this->getValue(self::ENV_CLIENT_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail(): string
    {
        return $this->getValue(self::ENV_CLIENT_EMAIL);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->getValue(self::ENV_CLIENT_NAME);
    }

    /**
     * @throws ConfigurationException
     */
    private function getValue(string $fieldName): string
    {
        if (!isset($this->envData)) {
            $dotEnvFilePath = __DIR__ . '/../../etc/';
            $this->envData = $this->dotEnvReader->getEnvValues($dotEnvFilePath);
        }

        $value = $this->envData[$fieldName] ?? '';
        if (!$value) {
            throw new ConfigurationException(\sprintf('.env file missing value for field \'%s\'.', $fieldName));
        }

        return $value;
    }
}
