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

use SuperMetrics\Client\Exception\HttpRequestException;

interface HttpRequestInterface
{
    /**
     * Sends http request using http method (get/post), url, get/post parameters and headers
     * Returns result in json encoded format
     *
     * @param array|string[] $headers
     *
     * @return string|null
     *
     * @throws HttpRequestException
     */
    public function request(
        string $httpMethod,
        string $url,
        array $parameters = null,
        array $headers = ['Content-Type: application/json']
    );

    /**
     * Initialize Http Request
     *
     * @param bool $isTest then return false
     *
     * @throws HttpRequestException
     */
    public function init(bool $isTest = false): void;

    /**
     * Http Request Options
     *
     * @param mixed $value
     */
    public function setOption(int $name, $value): bool;

    /**
     * Executes request and return response
     *
     * @param bool $isTest when true, returns test message
     */
    public function execute(bool $isTest): ?string;

    /**
     * Closes request handle
     */
    public function close(): void;
}
