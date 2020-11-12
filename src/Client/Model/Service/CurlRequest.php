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

use SuperMetrics\Client\Api\Service\HttpRequestInterface;
use SuperMetrics\Client\Exception\HttpRequestException;

class CurlRequest implements HttpRequestInterface
{
    private $curl = null;

    public function request(
        string $httpMethod,
        string $url,
        ?array $parameters = null,
        array $headers = ['Content-Type: application/json'],
        bool $isTest = false
    ) {
        $method = $httpMethod;

        $this->init();

        if ($method === 'POST') {
            $this->setOption(CURLOPT_POST, 1);
            if ($parameters) {
                $requestBody = \json_encode($parameters);
                $this->setOption(CURLOPT_POSTFIELDS, $requestBody);
            }
        } elseif ($method === 'GET') {
            if ($parameters) {
                $url = \sprintf('%s?%s', $url, \http_build_query($parameters));
            }
        } else {
            throw new HttpRequestException(\sprintf('Unsupported HTTP method \'%s\'.', $httpMethod));
        }
        $this->setOption(CURLOPT_URL, $url);
        $this->setOption(CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $this->setOption(CURLOPT_RETURNTRANSFER, 1);

        $this->setOption(CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $result = $this->execute($isTest);
        $this->close();
        if (!$result) {
            throw new HttpRequestException(\sprintf('Unable to connect to \'%s\'.', $url));
        }

        return $result;
    }

    public function init(bool $isTest = false): void
    {
        $this->curl = !$isTest ? \curl_init() : null;
        if (!$this->curl) {
            throw new HttpRequestException('Unable to initialize curl.');
        }
    }

    public function setOption(int $name, $value): bool
    {
        return \curl_setopt($this->curl, $name, $value);
    }

    public function execute(bool $isTest = false): ?string
    {
        if ($isTest) {
            return \json_encode(['data' => 'test']);
        }

        return \curl_exec($this->curl) ?: null;
    }

    public function close(): void
    {
        \curl_close($this->curl);
    }
}
