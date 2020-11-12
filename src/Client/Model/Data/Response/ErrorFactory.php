<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Model\Data\Response;

use SuperMetrics\Client\Api\Data\Response\ErrorInterface;

class ErrorFactory
{
    /**
     * @return Error|null
     */
    public function create(
        ?array $rawError
    ): ?ErrorInterface {
        return new Error($rawError);
    }
}
