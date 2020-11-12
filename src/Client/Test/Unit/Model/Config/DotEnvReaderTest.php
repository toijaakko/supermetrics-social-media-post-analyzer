<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Test\Unit\Model\Config;

use PHPUnit\Framework\TestCase;
use SuperMetrics\Client\Exception\ConfigurationException;
use SuperMetrics\Client\Model\Config\DotEnvReader;

class DotEnvReaderTest extends TestCase
{
    private DotEnvReader $dotEnvReader;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dotEnvReader = new DotEnvReader();
    }

    public function testEnvFileMissingException(): void
    {
        $invalidDotEnvDirPath = 'invalid_path';
        $this->expectException(ConfigurationException::class);
        $this->expectExceptionMessage(\sprintf('Invalid environment file path \'%s\'.env', $invalidDotEnvDirPath));
        $this->dotEnvReader->getEnvValues($invalidDotEnvDirPath);
    }

    public function testGetEnvData(): void
    {
        $dotEnvDirPath = __DIR__ . '/../../../fixture/etc/';
        self::assertNotEmpty($this->dotEnvReader->getEnvValues($dotEnvDirPath));
    }
}
