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

use PHPUnit\Framework\TestCase;
use SuperMetrics\Client\Api\Data\RequestInterface;
use SuperMetrics\Client\Model\Data\Request;
use SuperMetrics\Client\Model\Data\RequestFactory;

class RequestTest extends TestCase
{
    private string $urlPath;

    private array $parameters;

    private Request $request;

    private RequestFactory $requestFactory;

    protected function setup(): void
    {
        parent::setUp();
        $this->urlPath = 'https://domain/path';

        $this->parameters = ['parameter' => 'value'];

        $this->requestFactory = new RequestFactory();

        $this->request = $this->requestFactory->create($this->urlPath, $this->parameters);

        self::assertInstanceOf(RequestInterface::class, $this->request);
    }

    public function testGetUrlPath(): void
    {
        self::assertEquals($this->urlPath, $this->request->getUrlPath());
    }

    public function testGetRequestParameters(): void
    {
        self::assertEquals($this->parameters, $this->request->getRequestParameters());
    }
}
