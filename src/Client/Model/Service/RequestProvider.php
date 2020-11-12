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

use SuperMetrics\Client\Api\Config\ConfigurationInterface;
use SuperMetrics\Client\Api\Data\RequestInterface;
use SuperMetrics\Client\Api\Service\RequestProviderInterface;
use SuperMetrics\Client\Model\Data\RequestFactory;

class RequestProvider implements RequestProviderInterface
{
    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    private RequestFactory $requestFactory;

    public function __construct(
        ConfigurationInterface $configuration,
        RequestFactory $requestFactory
    ) {
        $this->configuration = $configuration;
        $this->requestFactory = $requestFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenRequest(): RequestInterface
    {
        $urlPath = $this->configuration->getTokenUrl();
        $clientId = $this->configuration->getClientId();
        $email = $this->configuration->getEmail();
        $name = $this->configuration->getName();
        $params = [
            self::REQUEST_PARAM_CLIENT_ID => $clientId,
            self::REQUEST_PARAM_EMAIL => $email,
            self::REQUEST_PARAM_NAME => $name,
        ];

        return $this->requestFactory->create($urlPath, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function getPostsRequest(string $token, int $pageNum): RequestInterface
    {
        $urlPath = $this->configuration->getPostsUrl();
        $params = [
            self::REQUEST_PARAM_TOKEN => $token,
            self::REQUEST_PARAM_PAGE => $pageNum,
        ];

        return $this->requestFactory->create($urlPath, $params);
    }
}
