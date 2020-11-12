<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\PostAnalyzer\Api\Data;

use SuperMetrics\Client\Api\Data\PostInterface;
use SuperMetrics\PostAnalyzer\Api\Service\PostStatCollectorPoolInterface;

interface PostCollectionInterface
{
    /**
     * Add post to post collection
     */
    public function addPost(PostInterface $post): void;

    /**
     * Remove post from post collection by post ID
     */
    public function removePostById(string $postId): void;

    /**
     * Get post by post ID from post collection
     */
    public function getByPostId(string $postId): PostInterface;

    /**
     * Get stat collector pools
     */
    public function getStatCollectorPool(): PostStatCollectorPoolInterface;
}
