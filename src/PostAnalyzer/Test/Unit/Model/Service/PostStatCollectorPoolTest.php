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

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SuperMetrics\PostAnalyzer\Api\Service\PostStatCollectorInterface;

class PostStatCollectorPoolTest extends TestCase
{
    /**
     * @var PostStatCollectorInterface[]
     */
    private array $statCollectors;
    /**
     * @var MockObject|PostStatCollectorInterface
     */
    private $statCollector;

    private PostStatCollectorPool $postStatCollectorPool;

    protected function setUp(): void
    {
        $this->statCollector = $this->createMock(PostStatCollectorInterface::class);

        $this->postStatCollectorPool = new PostStatCollectorPool([$this->statCollector]);
    }

    public function testGetCollectors(): void
    {
        self::assertContains($this->statCollector, $this->postStatCollectorPool->getCollectors());
    }
}
