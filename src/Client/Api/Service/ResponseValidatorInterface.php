<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Api\Service;

use SuperMetrics\Client\Api\Data\ResponseInterface;
use SuperMetrics\Client\Exception\ResponseValidationException;

interface ResponseValidatorInterface
{
    public const INVALID_SL_TOKEN_MESSAGE = 'Invalid SL Token';

    /**
     * Validate response
     *
     * @throws ResponseValidationException
     */
    public function validate(ResponseInterface $response): void;
}
