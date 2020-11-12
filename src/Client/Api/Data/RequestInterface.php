<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Api\Data;

interface RequestInterface
{
    /**
     * Get url path
     */
    public function getUrlPath(): string;

    /**
     * Get request parameters
     */
    public function getRequestParameters(): array;
}
