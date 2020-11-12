<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Model\Service;

use SuperMetrics\Client\Api\Data\ResponseInterface;
use SuperMetrics\Client\Api\Service\ResponseValidatorInterface;
use SuperMetrics\Client\Exception\ResponseValidationException;

class ResponseValidator implements ResponseValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate(ResponseInterface $response): void
    {
        if ($error = $response->getError()) {
            $errorCode = $error->getErrorCode() === self::INVALID_SL_TOKEN_MESSAGE
                ? ResponseValidationException::ERROR_CODE_INVALID_SL_TOKEN
                : 0;
            throw new ResponseValidationException(\sprintf('Error in response. Error code: \'%s\'. Error message: \'%s\'. Error description: \'%s\'', $error->getErrorCode(), $error->getErrorMessage(), $error->getErrorDescription()), $errorCode);
        }
        if (!$data = $response->getData()) {
            throw new ResponseValidationException('No data in response.');
        }
    }
}
