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
use SuperMetrics\Client\Api\Data\RequestInterface;
use SuperMetrics\Client\Api\Data\ResponseInterface;
use SuperMetrics\Client\Api\Service\HttpRequestInterface;
use SuperMetrics\Client\Exception\ClientException;
use SuperMetrics\Client\Model\Data\ResponseFactory;
use SuperMetrics\Client\Model\Service\HttpClient;

class HttpClientTest extends TestCase
{
    private MockObject $request;

    private MockObject $response;

    private HttpClient $httpClient;
    /**
     * @var MockObject|ResponseFactory
     */
    private MockObject $responseFactory;

    private MockObject $httpRequest;

    protected function setUp(): void
    {
        $this->request = $this->createMock(RequestInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->responseFactory = $this->createMock(ResponseFactory::class);
        $this->httpRequest = $this->createMock(HttpRequestInterface::class);

        $this->httpClient = new HttpClient($this->responseFactory, $this->httpRequest);
    }

    public function testGet(): void
    {
        $path = 'https://domain/path';
        $this->request
            ->expects(self::once())
            ->method('getUrlPath')
            ->willReturn($path);

        $parameters = ['client_id' => '1234', 'email' => 'email@name.com'];
        $this->request
            ->expects(self::once())
            ->method('getRequestParameters')
            ->willReturn($parameters);

        $response = \json_encode(['data' => 'data']);

        $this->httpRequest
            ->expects(self::once())
            ->method('request')
            ->with('GET', $path, $parameters)
            ->wilLReturn($response);

        $this->responseFactory
            ->expects(self::once())
            ->method('create')
            ->with($response)
            ->willReturn($this->response);

        self::assertEquals($this->response, $this->httpClient->get($this->request));
    }

    public function testGetException(): void
    {
        $path = 'https://domain/path';
        $this->request
            ->expects(self::once())
            ->method('getUrlPath')
            ->willReturn($path);

        $parameters = ['token' => '1234', 'page' => 1];
        $this->request
            ->expects(self::once())
            ->method('getRequestParameters')
            ->willReturn($parameters);

        $exception = new ClientException('error');

        $this->httpRequest
            ->expects(self::once())
            ->method('request')
            ->with('GET', $path, $parameters)
            ->willThrowException($exception);

        $this->expectException(ClientException::class);
        $this->httpClient->get($this->request);
    }

    public function testPost(): void
    {
        $path = 'https://domain/path';
        $this->request
            ->expects(self::once())
            ->method('getUrlPath')
            ->willReturn($path);

        $parameters = ['client_id' => '1234', 'email' => 'name@email.com', 'name' => 'Name'];

        $this->request
            ->expects(self::once())
            ->method('getRequestParameters')
            ->willReturn($parameters);

        $this->request
            ->expects(self::once())
            ->method('getRequestParameters')
            ->willReturn($parameters);

        $this->responseFactory
            ->expects(self::atMost(1))
            ->method('create')
            ->willReturn($this->response);

        self::assertEquals($this->response, $this->httpClient->post($this->request));
    }
}
