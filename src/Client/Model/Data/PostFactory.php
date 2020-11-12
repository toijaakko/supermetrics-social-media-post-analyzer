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

use SuperMetrics\Client\Api\Data\PostInterface;

class PostFactory
{
    /**
     * Create Post instance
     */
    public function create(
        ?string $id,
        ?string $fromName,
        ?string $fromId,
        ?string $message,
        ?string $type,
        ?string $createdTime
    ): PostInterface {
        return new Post($id, $fromName, $fromId, $message, $type, $createdTime);
    }
}
