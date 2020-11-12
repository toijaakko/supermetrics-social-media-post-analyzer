<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Test\Unit\Model\Data;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SuperMetrics\Client\Api\Data\Response\DataInterface;
use SuperMetrics\Client\Api\Data\Response\ErrorInterface;
use SuperMetrics\Client\Api\Data\Response\MetaInterface;
use SuperMetrics\Client\Api\Data\ResponseInterface;
use SuperMetrics\Client\Model\Data\Response\DataFactory;
use SuperMetrics\Client\Model\Data\Response\ErrorFactory;
use SuperMetrics\Client\Model\Data\Response\MetaFactory;
use SuperMetrics\Client\Model\Data\ResponseFactory;

class ResponseTest extends TestCase
{
    private ResponseFactory $responseFactory;
    private array $rawResponse;

    /**
     * @var false|string
     */
    private $jsonResponse;

    private ResponseInterface $emptyResponse;
    /**
     * @var MockObject|DataInterface
     */
    private $responseData;
    /**
     * @var MockObject|ErrorInterface
     */
    private $responseError;
    /**
     * @var MockObject|MetaInterface
     */
    private $responseMeta;
    /**
     * @var MockObject|MetaFactory
     */
    private $responseMetaFactory;
    /**
     * @var MockObject|ErrorFactory
     */
    private $responseErrorFactory;
    /**
     * @var MockObject|DataFactory
     */
    private $responseDataFactory;

    private ResponseInterface $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->responseDataFactory = $this->createMock(DataFactory::class);
        $this->responseErrorFactory = $this->createMock(ErrorFactory::class);
        $this->responseMetaFactory = $this->createMock(MetaFactory::class);
        $this->responseFactory = new ResponseFactory(
            $this->responseDataFactory,
            $this->responseErrorFactory,
            $this->responseMetaFactory,
        );

        $this->responseData = $this->createMock(DataInterface::class);
        $this->responseError = $this->createMock(ErrorInterface::class);
        $this->responseMeta = $this->createMock(MetaInterface::class);
        $this->rawResponse =
            [
                'data' => [
                    'sl_token' => '309483094',
                    'page' => 1,
                    'posts' => ['id' => '234234'],
                ],
                'error' => [
                    'code' => 'error code',
                    'message' => 'error message',
                    'description' => 'error description',
                ],
                'meta' => [
                    'request_id' => '329484',
                ],
            ];

        $this->jsonResponse = \json_encode($this->rawResponse);
        $this->response = $this->responseFactory->create(
            $this->jsonResponse,
            $this->responseDataFactory,
            $this->responseErrorFactory,
            $this->responseMetaFactory
        );
        $this->emptyResponse = $this->responseFactory->create('');
    }

    public function testGetRawResponse(): void
    {
        self::assertEquals($this->jsonResponse, $this->response->getRawResponse());
        self::assertEquals('', $this->emptyResponse->getRawResponse());
    }

    public function testGetData(): void
    {
        $this->responseDataFactory
            ->expects(self::once())
            ->method('create')
            ->withAnyParameters()
            ->willReturn($this->responseData);
        self::assertInstanceOf(DataInterface::class, $this->response->getData());
        self::assertNull($this->emptyResponse->getData());
    }

    public function testGetError(): void
    {
        $this->responseErrorFactory
            ->expects(self::once())
            ->method('create')
            ->withAnyParameters()
            ->willReturn($this->responseError);
        self::assertEquals($this->responseError, $this->response->getError());
        self::assertNull($this->emptyResponse->getError());
    }

    public function testGetMeta(): void
    {
        $this->responseMetaFactory
            ->expects(self::once())
            ->method('create')
            ->withAnyParameters()
            ->willReturn($this->responseMeta);
        self::assertEquals($this->responseMeta, $this->response->getMeta());
        self::assertNull($this->emptyResponse->getMeta());
    }
}
