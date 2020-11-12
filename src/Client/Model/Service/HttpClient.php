<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Model\Service;

use SuperMetrics\Client\Api\Data\RequestInterface;
use SuperMetrics\Client\Api\Data\ResponseInterface;
use SuperMetrics\Client\Api\Service\HttpClientInterface;
use SuperMetrics\Client\Api\Service\HttpRequestInterface;
use SuperMetrics\Client\Model\Data\ResponseFactory;

class HttpClient implements HttpClientInterface
{
    private ResponseFactory $responseFactory;

    private HttpRequestInterface $httpRequest;

    /**
     * HttpClient constructor.
     */
    public function __construct(
        ResponseFactory $responseFactory,
        HttpRequestInterface $httpRequest
    ) {
        $this->responseFactory = $responseFactory;
        $this->httpRequest = $httpRequest;
    }

    /**
     * {@inheritdoc}
     */
    public function get(RequestInterface $request): ResponseInterface
    {
        $path = $request->getUrlPath();

        $parameters = $request->getRequestParameters();

        $response = $this->httpRequest->request('GET', $path, $parameters);

        return $this->responseFactory->create($response ?: null);
    }

    /**
     * {@inheritdoc}
     */
    public function post(RequestInterface $request): ResponseInterface
    {
        $path = $request->getUrlPath();

        $parameters = $request->getRequestParameters();

        $response = $this->httpRequest->request('POST', $path, $parameters);

        return $this->responseFactory->create($response ?: null);
    }
}
