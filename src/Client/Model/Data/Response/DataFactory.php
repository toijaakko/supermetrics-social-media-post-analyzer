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

use SuperMetrics\Client\Api\Data\Response\DataInterface;

class DataFactory
{
    public function create(
        ?array $rawData
    ): ?DataInterface {
        return new Data($rawData);
    }
}
