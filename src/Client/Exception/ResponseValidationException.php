<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Exception;

class ResponseValidationException extends \Exception
{
    public const ERROR_CODE_INVALID_SL_TOKEN = 1;
}
