<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Model\Data;

use SuperMetrics\Client\Api\Data\RequestInterface;

class Request implements RequestInterface
{
    private string $urlPath;

    private array $parameters;

    /**
     * Request constructor.
     */
    public function __construct(
        string $urlPath,
        array $parameters
    ) {
        $this->urlPath = $urlPath;
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlPath(): string
    {
        return $this->urlPath;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestParameters(): array
    {
        return $this->parameters;
    }
}
