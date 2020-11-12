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

use PHPUnit\Framework\TestCase;
use SuperMetrics\Client\Exception\HttpRequestException;
use SuperMetrics\Client\Model\Service\CurlRequest;

class HttpRequestTest extends TestCase
{
    private CurlRequest $httpRequest;

    protected function setUp(): void
    {
        $this->httpRequest = new CurlRequest();
    }

    public function testInitOptExcecuteAndClose(): void
    {
        $this->expectException(HttpRequestException::class);
        $this->httpRequest->init(true);
        self::assertTrue($this->httpRequest->setOption(CURLOPT_HTTPGET, 1));
        $this->httpRequest->execute(false);
        $this->httpRequest->close();
    }

    public function testRequestException(): void
    {
        $this->expectException(HttpRequestException::class);
        $this->expectExceptionMessage('Unsupported HTTP method \'PUT\'.');
        $this->httpRequest->request('PUT', 'http://some/path');
    }

    public function testRequestGet(): void
    {
        $result = $this->httpRequest
            ->request('GET', 'http://some/path', ['params' => 'params'], [], true);
        $expectedResult = \json_encode(['data' => 'test']);
        self::assertEquals($expectedResult, $result);
        $this->expectException(HttpRequestException::class);
        $this->httpRequest
            ->request('POST', 'http://some/path', ['params' => 'params'], [], false);
        self::assertEquals($expectedResult, $result);
    }
}
