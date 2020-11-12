<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Api\Config;

use SuperMetrics\Client\Exception\ConfigurationException;

interface ConfigurationInterface
{
    public const ENV_TOKEN_URL = 'URL_TOKEN';
    public const ENV_POSTS_URL = 'URL_POSTS';
    public const ENV_CLIENT_ID = 'CLIENT_ID';
    public const ENV_CLIENT_EMAIL = 'CLIENT_EMAIL';
    public const ENV_CLIENT_NAME = 'CLIENT_NAME';

    /**
     * Get token URL.
     *
     * @throws ConfigurationException
     */
    public function getTokenUrl(): string;

    /**
     * Get post URL.
     *
     * @throws ConfigurationException
     */
    public function getPostsUrl(): string;

    /**
     * Get client id for token registration
     *
     * @throws ConfigurationException
     */
    public function getClientId(): string;

    /**
     * Get email for token registration
     *
     * @throws ConfigurationException
     */
    public function getEmail(): string;

    /**
     * Get name for token registration
     *
     * @throws ConfigurationException
     */
    public function getName(): string;
}
