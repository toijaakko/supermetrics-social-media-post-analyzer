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

class Error implements ErrorInterface
{
    private ?array $rawError;

    public function __construct(
        ?array $rawError
    ) {
        $this->rawError = $rawError;
    }

    public function getRawError(): ?array
    {
        return $this->rawError;
    }

    public function getErrorCode(): ?string
    {
        return $this->rawError[self::FIELD_ERROR_CODE] ?? null;
    }

    public function getErrorMessage(): ?string
    {
        return $this->rawError[self::FIELD_ERROR_MESSAGE] ?? null;
    }

    public function getErrorDescription(): ?string
    {
        return $this->rawError[self::FIELD_ERROR_DESCRIPTION] ?? null;
    }
}
