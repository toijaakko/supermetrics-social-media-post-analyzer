<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Api\Data\Response;

interface MetaInterface
{
    public const FIELD_META_REQUEST_ID = 'request_id';

    public function getRawMeta(): ?array;

    public function getRequestId(): ?string;
}
