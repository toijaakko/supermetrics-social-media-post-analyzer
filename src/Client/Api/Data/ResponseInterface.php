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

use SuperMetrics\Client\Api\Data\Response\DataInterface;
use SuperMetrics\Client\Api\Data\Response\ErrorInterface;
use SuperMetrics\Client\Api\Data\Response\MetaInterface;

interface ResponseInterface
{
    public const FIELD_DATA = 'data';
    public const FIELD_META = 'meta';
    public const FIELD_ERROR = 'error';

    public function getRawResponse(): string;

    public function getData(): ?DataInterface;

    public function getError(): ?ErrorInterface;

    public function getMeta(): ?MetaInterface;
}
