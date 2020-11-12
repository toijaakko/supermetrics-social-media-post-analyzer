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

class Meta implements MetaInterface
{
    private ?array $rawMeta;

    public function __construct(
        ?array $rawMeta
    ) {
        $this->rawMeta = $rawMeta;
    }

    public function getRawMeta(): ?array
    {
        return $this->rawMeta;
    }

    public function getRequestId(): ?string
    {
        return $this->rawMeta[self::FIELD_META_REQUEST_ID] ?? null;
    }
}
