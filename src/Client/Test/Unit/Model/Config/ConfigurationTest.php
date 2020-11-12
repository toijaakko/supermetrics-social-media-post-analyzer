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

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SuperMetrics\Client\Api\Config\DotEnvReaderInterface;
use SuperMetrics\Client\Exception\ConfigurationException;
use SuperMetrics\Client\Model\Config\Configuration;

class ConfigurationTest extends TestCase
{
    private Configuration $configuration;
    private string $tokenUrl;
    private string $postUrl;
    private string $clientId;
    private string $email;
    private string $fullName;
    private string $dotEnvDirPath;
    private array $envData;
    /**
     * @var MockObject|DotEnvReaderInterface
     */
    private $dotEnvReader;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tokenUrl = 'http://domain/token';
        $this->postUrl = 'http://domain/posts';
        $this->clientId = '1234567';
        $this->email = 'name@email.com';
        $this->fullName = 'Firstname Lastname';
        $this->dotEnvDirPath = '/../../etc/';
        $this->envData = [
                Configuration::ENV_TOKEN_URL => $this->tokenUrl,
                Configuration::ENV_POSTS_URL => $this->postUrl,
                Configuration::ENV_CLIENT_ID => $this->clientId,
                Configuration::ENV_CLIENT_EMAIL => $this->email,
                Configuration::ENV_CLIENT_NAME => $this->fullName,
            ];

        $this->dotEnvReader = $this->createMock(DotEnvReaderInterface::class);

        $this->configuration = new Configuration($this->dotEnvReader);
    }

    public function testEnvFileMissingException(): void
    {
        $exceptionMessage = \sprintf('.env file missing from \'%s\'.', $this->dotEnvDirPath);
        $this->dotEnvReader
            ->expects(self::once())
            ->method('getEnvValues')
            ->willThrowException(new ConfigurationException($exceptionMessage));

        $this->expectException(ConfigurationException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $this->configuration->getTokenUrl();
    }

    public function testGetTokenUrl(): void
    {
        $this->dotEnvReader
            ->expects(self::once())
            ->method('getEnvValues')
            ->willReturn($this->envData);

        self::assertEquals($this->tokenUrl, $this->configuration->getTokenUrl());
    }

    public function testGetPostUrl(): void
    {
        $this->dotEnvReader
            ->expects(self::once())
            ->method('getEnvValues')
            ->willReturn($this->envData);

        self::assertEquals($this->postUrl, $this->configuration->getPostsUrl());
    }

    public function testGetClientId(): void
    {
        $this->dotEnvReader
            ->expects(self::once())
            ->method('getEnvValues')
            ->willReturn($this->envData);

        self::assertEquals($this->clientId, $this->configuration->getClientId());
    }

    public function testGetEmail(): void
    {
        $this->dotEnvReader
            ->expects(self::once())
            ->method('getEnvValues')
            ->willReturn($this->envData);

        self::assertEquals($this->email, $this->configuration->getEmail());
    }

    public function testGetName(): void
    {
        $this->dotEnvReader
            ->expects(self::once())
            ->method('getEnvValues')
            ->willReturn($this->envData);

        self::assertEquals($this->fullName, $this->configuration->getName());
    }

    public function testMissingFieldException(): void
    {
        foreach ($this->envData as $fieldName => $envValue) {
            $this->expectException(ConfigurationException::class);
            $this->expectExceptionMessage(\sprintf('.env file missing value for field \'%s\'.', $fieldName));
            switch ($fieldName) {
                case Configuration::ENV_TOKEN_URL:
                    $this->configuration->getTokenUrl();
                    break;
                case Configuration::ENV_POSTS_URL:
                    $this->configuration->getPostsUrl();
                    break;
                case Configuration::ENV_CLIENT_ID:
                    $this->configuration->getClientId();
                    break;
                case Configuration::ENV_CLIENT_EMAIL:
                    $this->configuration->getEmail();
                    break;
                case Configuration::ENV_CLIENT_NAME:
                    $this->configuration->getName();
                    break;
                default:
                    break;
            }
        }
    }
}
