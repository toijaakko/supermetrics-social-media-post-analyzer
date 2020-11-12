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

use SuperMetrics\Client\Api\Service\ClientInterface;
use SuperMetrics\Client\Api\Service\HttpClientInterface;
use SuperMetrics\Client\Api\Service\RequestProviderInterface;
use SuperMetrics\Client\Api\Service\ResponseParserInterface;
use SuperMetrics\Client\Api\Service\ResponseValidatorInterface;
use SuperMetrics\Client\Exception\ClientException;
use SuperMetrics\Client\Exception\HttpRequestException;
use SuperMetrics\Client\Exception\ResponseValidationException;

class Client implements ClientInterface
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;
    /**
     * @var RequestProviderInterface
     */
    private $requestProvider;
    /**
     * @var ResponseParserInterface
     */
    private $responseParser;

    private ResponseValidatorInterface $responseValidator;

    private int $errorCount;
    private string $token;

    /**
     * Client constructor.
     */
    public function __construct(
        HttpClientInterface $httpClient,
        RequestProviderInterface $requestProvider,
        ResponseValidatorInterface $responseValidator,
        ResponseParserInterface $responseParser
    ) {
        $this->httpClient = $httpClient;
        $this->requestProvider = $requestProvider;
        $this->responseParser = $responseParser;
        $this->responseValidator = $responseValidator;
        $this->errorCount = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getPosts(int $pageNum): array
    {
        if (!isset($this->token) || !$this->token) {
            try {
                $this->token = $this->getToken();
            } catch (\Exception $e) {
                throw new ClientException(\sprintf('Error getting token. Reason: %s', $e->getMessage()), 0, $e->getPrevious());
            }
        }

        $request = $this->requestProvider->getPostsRequest($this->token, $pageNum);

        try {
            $response = $this->httpClient->get($request);
        } catch (HttpRequestException $e) {
            throw new ClientException(\sprintf('Error sending get post request. Reason: %s', $e->getMessage()), 0, $e->getPrevious());
        }

        try {
            $this->responseValidator->validate($response);

            return $this->responseParser->getPosts($response);
        } catch (ResponseValidationException $e) {
            if ($e->getCode() === ResponseValidationException::ERROR_CODE_INVALID_SL_TOKEN && !$this->errorCount) {
                unset($this->token);
                $this->errorCount = 1;

                return $this->getPosts($pageNum);
            }
            throw new ClientException(\sprintf('Unable to fetch posts. Reason: %s', $e->getMessage()));
        }
    }

    private function getToken(): string
    {
        $request = $this->requestProvider->getTokenRequest();

        $response = $this->httpClient->post($request);

        $this->responseValidator->validate($response);

        return $this->responseParser->getToken($response);
    }
}
