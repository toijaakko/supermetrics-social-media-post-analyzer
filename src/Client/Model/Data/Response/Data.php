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

class Data implements DataInterface
{
    private ?array $rawData;

    public function __construct(
        ?array $rawData
    ) {
        $this->rawData = $rawData;
    }

    public function getRawData(): ?array
    {
        return $this->rawData;
    }

    public function getClientId(): ?string
    {
        return $this->rawData[self::FIELD_DATA_CLIENT_ID] ?? null;
    }

    public function getToken(): ?string
    {
        return $this->rawData[self::FIELD_DATA_TOKEN] ?? null;
    }

    public function getPageNumber(): ?string
    {
        return $this->rawData[self::FIELD_DATA_PAGE_NUMBER] ?? null;
    }

    public function getPosts(): ?array
    {
        return $this->rawData[self::FIELD_DATA_POSTS] ?? null;
    }
}
