<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\PostAnalyzer\Api\Service;

use SuperMetrics\Client\Api\Data\PostInterface;
use SuperMetrics\PostAnalyzer\Exception\PostStatCollectorException;

/**
 * Interface for collecting stat for posts
 */
interface PostStatCollectorInterface
{
    /**
     * Get description of the post stat collector
     */
    public function getStatDescription(): string;

    /**
     * Add post to generate/update statistic for the collector
     *
     * @throws PostStatCollectorException
     */
    public function addPost(PostInterface $post): void;

    /**
     * Remove post and update statistics for the collector
     *
     * @throws PostStatCollectorException
     */
    public function removePost(PostInterface $post): void;

    /**
     * Get result of collected stat metrics
     *
     * @return mixed
     */
    public function getResult();
}
