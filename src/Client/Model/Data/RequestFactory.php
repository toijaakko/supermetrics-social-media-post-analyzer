<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Model\Data;

class RequestFactory
{
    /**
     * @return Request
     */
    public function create(string $urlPath, array $parameters)
    {
        return new Request($urlPath, $parameters);
    }
}
