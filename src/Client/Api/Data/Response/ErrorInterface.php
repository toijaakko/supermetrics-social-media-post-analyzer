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

interface ErrorInterface
{
    public const FIELD_ERROR_CODE = 'code';
    public const FIELD_ERROR_MESSAGE = 'message';
    public const FIELD_ERROR_DESCRIPTION = 'description';

    public function getRawError(): ?array;

    public function getErrorCode(): ?string;

    public function getErrorMessage(): ?string;

    public function getErrorDescription(): ?string;
}
