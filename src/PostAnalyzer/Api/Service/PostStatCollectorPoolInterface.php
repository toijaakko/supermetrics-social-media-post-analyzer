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

/**
 * Gets pool of stat collectors
 */
interface PostStatCollectorPoolInterface
{
    /**
     * @return PostStatCollectorInterface[]
     */
    public function getCollectors(): array;
}
