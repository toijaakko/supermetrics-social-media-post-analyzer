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

use SuperMetrics\Client\Api\Data\Response\MetaInterface;

class MetaFactory
{
    public function create(
        ?array $rawMeta
    ): ?MetaInterface {
        return new Meta($rawMeta);
    }
}
