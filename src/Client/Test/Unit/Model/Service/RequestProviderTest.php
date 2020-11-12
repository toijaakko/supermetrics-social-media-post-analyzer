<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Test\Unit\Model\Service;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SuperMetrics\Client\Api\Config\ConfigurationInterface;
use SuperMetrics\Client\Api\Data\RequestInterface;
use SuperMetrics\Client\Api\Service\RequestProviderInterface;
use SuperMetrics\Client\Model\Data\RequestFactory;
use SuperMetrics\Client\Model\Service\RequestProvider;

class RequestProviderTest extends TestCase
{
    /**
     * @var MockObject|ConfigurationInterface
     */
    private $configuration;
    /**
     * @var MockObject|RequestFactory
     */
    private $requestFactory;
    /**
     * @var MockObject|RequestInterface
     */
    private $request;

    private RequestProvider $requestProvider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->configuration = $this->createMock(ConfigurationInterface::class);
        $this->requestFactory = $this->createMock(RequestFactory::class);
        $this->request = $this->createMock(RequestInterface::class);

        $this->requestProvider = new RequestProvider($this->configuration, $this->requestFactory);
    }

    public function testGetTokenRequest(): void
    {
        $urlPath = 'https://domain/path';
        $clientId = 'clientId';
        $email = 'name@company.com';
        $name = 'Firstname Lastname';

        $this->configuration
            ->expects(self::once())
            ->method('getTokenUrl')
            ->willReturn($urlPath);

        $this->configuration
            ->expects(self::once())
            ->method('getClientId')
            ->willReturn($clientId);

        $this->configuration
            ->expects(self::once())
            ->method('getEmail')
            ->willReturn($email);

        $this->configuration
            ->expects(self::once())
            ->method('getName')
            ->willReturn($name);

        $params = [
            RequestProviderInterface::REQUEST_PARAM_CLIENT_ID => $clientId,
            RequestProviderInterface::REQUEST_PARAM_EMAIL => $email,
            RequestProviderInterface::REQUEST_PARAM_NAME => $name,
        ];

        $this->requestFactory
            ->expects(self::once())
            ->method('create')
            ->with($urlPath, $params)
            ->willReturn($this->request);

        self::assertEquals($this->request, $this->requestProvider->getTokenRequest());
    }

    public function testGetPostsRequest(): void
    {
        $urlPath = 'https://domain/path';

        $token = 'token';
        $pageNum = 1;

        $this->configuration
            ->expects(self::once())
            ->method('getPostsUrl')
            ->willReturn($urlPath);

        $params = [
            RequestProviderInterface::REQUEST_PARAM_TOKEN => $token,
            RequestProviderInterface::REQUEST_PARAM_PAGE => $pageNum,
        ];

        $this->requestFactory
            ->expects(self::once())
            ->method('create')
            ->with($urlPath, $params)
            ->willReturn($this->request);

        self::assertEquals($this->request, $this->requestProvider->getPostsRequest($token, $pageNum));
    }
}
