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

use SuperMetrics\Client\Api\Data\PostInterface;
use SuperMetrics\Client\Api\Data\ResponseInterface;
use SuperMetrics\Client\Exception\ResponseValidationException;

interface ResponseParserInterface
{
    /**
     * Get authentication token from response
     *
     * @throws ResponseValidationException
     */
    public function getToken(ResponseInterface $response): string;

    /**
     * Get posts from response
     *
     * @return PostInterface[]
     *
     * @throws ResponseValidationException
     */
    public function getPosts(ResponseInterface $response): array;
}
