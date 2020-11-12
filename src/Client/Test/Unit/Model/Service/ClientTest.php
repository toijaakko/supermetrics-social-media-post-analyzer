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
use SuperMetrics\Client\Api\Data\PostInterface;
use SuperMetrics\Client\Api\Data\RequestInterface;
use SuperMetrics\Client\Api\Data\ResponseInterface;
use SuperMetrics\Client\Api\Service\HttpClientInterface;
use SuperMetrics\Client\Api\Service\RequestProviderInterface;
use SuperMetrics\Client\Api\Service\ResponseParserInterface;
use SuperMetrics\Client\Api\Service\ResponseValidatorInterface;
use SuperMetrics\Client\Exception\ClientException;
use SuperMetrics\Client\Exception\HttpRequestException;
use SuperMetrics\Client\Exception\ResponseValidationException;
use SuperMetrics\Client\Model\Service\Client;

class ClientTest extends TestCase
{
    /**
     * @var MockObject|HttpClientInterface
     */
    private $httpClient;
    /**
     * @var MockObject|RequestProviderInterface
     */
    private $requestProvider;
    /**
     * @var MockObject|ResponseParserInterface
     */
    private $responseParser;
    /**
     * @var MockObject|ResponseValidatorInterface
     */
    private $responseValidator;

    private Client $client;
    /**
     * @var MockObject|RequestInterface
     */
    private $request;
    /**
     * @var MockObject|ResponseInterface
     */
    private $response;
    /**
     * @var MockObject|PostInterface
     */
    private $post;

    private MockObject $responseValidationException;

    private MockObject $httpRequestException;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpClientInterface::class);
        $this->requestProvider = $this->createMock(RequestProviderInterface::class);
        $this->responseParser = $this->createMock(ResponseParserInterface::class);
        $this->responseValidator = $this->createMock(ResponseValidatorInterface::class);
        $this->request = $this->createMock(RequestInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->post = $this->createMock(PostInterface::class);
        $this->responseValidationException = $this->createMock(ResponseValidationException::class);
        $this->httpRequestException = $this->createMock(HttpRequestException::class);

        $this->client = new Client(
            $this->httpClient,
            $this->requestProvider,
            $this->responseValidator,
            $this->responseParser
        );
    }

    public function testGetPosts()
    {
        $token = 'token123';
        $pageNum = 4;
        $this->requestProvider
            ->expects(self::once())
            ->method('getTokenRequest')
            ->willReturn($this->request);

        $this->httpClient
            ->expects(self::once())
            ->method('post')
            ->with($this->request)
            ->willReturn($this->response);

        $this->responseValidator
                ->expects(self::exactly(2))
                ->method('validate')
                ->with($this->response);

        $this->responseParser
            ->expects(self::once())
            ->method('getToken')
            ->with($this->response)
            ->willReturn($token);

        $this->requestProvider
            ->expects(self::once())
            ->method('getPostsRequest')
            ->with($token, $pageNum)
            ->willReturn($this->request);

        $this->httpClient
            ->expects(self::once())
            ->method('get')
            ->with($this->request)
            ->willReturn($this->response);

        $this->responseParser
                ->expects(self::once())
                ->method('getPosts')
                ->with($this->response)
                ->willReturn([$this->post]);

        $posts = $this->client->getPosts($pageNum);
        self::assertEquals([$this->post], $posts);
    }

    public function testGetPostsExceptions()
    {
        $token = 'token123';
        $pageNum = 4;
        $this->requestProvider
            ->expects(self::exactly(2))
            ->method('getTokenRequest')
            ->willReturn($this->request);

        $this->httpClient
            ->expects(self::exactly(2))
            ->method('post')
            ->with($this->request)
            ->willReturn($this->response);

        $this->responseParser
            ->expects(self::exactly(2))
            ->method('getToken')
            ->with($this->response)
            ->willReturn($token);

        $this->requestProvider
            ->expects(self::exactly(2))
            ->method('getPostsRequest')
            ->with($token, $pageNum)
            ->willReturn($this->request);

        $this->httpClient
            ->expects(self::exactly(2))
            ->method('get')
            ->with($this->request)
            ->willReturn($this->response);

        $this->responseValidator
                ->expects(self::exactly(4))
                ->method('validate')
                ->with($this->response)
                ->willReturnOnConsecutiveCalls(
                    null,
                    self::throwException(new ResponseValidationException('Invalid token', 1)),
                    null,
                    self::throwException(new ResponseValidationException('Invalid token', 1))
                );
        $this->expectException(ClientException::class);

        $this->client->getPosts($pageNum);
    }

    public function testClientExceptionOnToken()
    {
        $pageNum = 4;
        $this->requestProvider
            ->expects(self::once())
            ->method('getTokenRequest')
            ->willReturn($this->request);

        $this->httpClient
            ->expects(self::once())
            ->method('post')
            ->with($this->request)
            ->willThrowException($this->responseValidationException);

        $this->expectException(ClientException::class);
        $this->client->getPosts($pageNum);
    }

    public function testGetPostsRequestExceptions()
    {
        $token = 'token123';
        $pageNum = 4;
        $this->requestProvider
            ->expects(self::once())
            ->method('getTokenRequest')
            ->willReturn($this->request);

        $this->httpClient
            ->expects(self::once())
            ->method('post')
            ->with($this->request)
            ->willReturn($this->response);

        $this->responseParser
            ->expects(self::once())
            ->method('getToken')
            ->with($this->response)
            ->willReturn($token);

        $this->requestProvider
            ->expects(self::once())
            ->method('getPostsRequest')
            ->with($token, $pageNum)
            ->willReturn($this->request);

        $this->httpClient
            ->expects(self::once())
            ->method('get')
            ->with($this->request)
            ->willThrowException($this->httpRequestException);

        $this->expectException(ClientException::class);

        $this->client->getPosts($pageNum);
    }
}
