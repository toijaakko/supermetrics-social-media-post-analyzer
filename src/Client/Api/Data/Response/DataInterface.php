<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Api\Data\Response;

interface DataInterface
{
    public const FIELD_DATA_CLIENT_ID = 'client_id';
    public const FIELD_DATA_EMAIL = 'email';
    public const FIELD_DATA_TOKEN = 'sl_token';
    public const FIELD_DATA_PAGE_NUMBER = 'page';
    public const FIELD_DATA_POSTS = 'posts';

    public function getRawData(): ?array;

    public function getClientId(): ?string;

    public function getToken(): ?string;

    public function getPageNumber(): ?string;

    public function getPosts(): ?array;
}
