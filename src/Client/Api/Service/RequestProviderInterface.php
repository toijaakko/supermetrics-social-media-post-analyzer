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

use SuperMetrics\Client\Api\Data\RequestInterface;

interface RequestProviderInterface
{
    public const REQUEST_PARAM_CLIENT_ID = 'client_id';
    public const REQUEST_PARAM_EMAIL = 'email';
    public const REQUEST_PARAM_NAME = 'name';
    public const REQUEST_PARAM_TOKEN = 'sl_token';
    public const REQUEST_PARAM_PAGE = 'page';

    /**
     * Get token request
     */
    public function getTokenRequest(): RequestInterface;

    /**
     * Get posts request
     */
    public function getPostsRequest(string $token, int $pageNum): RequestInterface;
}
