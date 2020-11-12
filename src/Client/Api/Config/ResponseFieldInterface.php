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

interface ResponseFieldInterface
{
    public const RESPONSE_FIELD_TOKEN = 'sl_token';
    public const RESPONSE_FIELD_CLIENT_ID = 'client_id';
    public const RESPONSE_FIELD_EMAIL = 'email';
    public const RESPONSE_FIELD_PAGE = 'page';
    public const RESPONSE_FIELD_POSTS = 'posts';
}
