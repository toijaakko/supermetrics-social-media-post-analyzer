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
use SuperMetrics\Client\Exception\ClientException;

interface ClientInterface
{
    /**
     * Get posts from page number
     *
     * @return PostInterface[]
     *
     * @throws ClientException
     */
    public function getPosts(int $pageNum): array;
}
