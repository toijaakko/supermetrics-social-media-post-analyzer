<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\PostAnalyzer\Model\Service;

use SuperMetrics\PostAnalyzer\Api\Service\PostStatCollectorInterface;
use SuperMetrics\PostAnalyzer\Api\Service\PostStatCollectorPoolInterface;

class PostStatCollectorPool implements PostStatCollectorPoolInterface
{
    /**
     * @var PostStatCollectorInterface[]
     */
    private array $statCollectors;

    public function __construct(array $statCollectors)
    {
        $this->statCollectors = $statCollectors;
    }

    public function getCollectors(): array
    {
        return $this->statCollectors;
    }
}
