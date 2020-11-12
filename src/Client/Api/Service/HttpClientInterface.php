<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Api\Service;

use  SuperMetrics\Client\Api\Data\RequestInterface;
use SuperMetrics\Client\Api\Data\ResponseInterface;
use SuperMetrics\Client\Exception\HttpRequestException;

interface HttpClientInterface
{
    /**
     * Send a GET request
     *
     * @throws HttpRequestException
     */
    public function get(RequestInterface $request): ResponseInterface;

    /**
     * Send a POST request
     *
     * @throws HttpRequestException
     */
    public function post(RequestInterface $request): ResponseInterface;
}
