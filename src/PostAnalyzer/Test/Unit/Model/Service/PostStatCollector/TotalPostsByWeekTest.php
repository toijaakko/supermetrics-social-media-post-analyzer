<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\PostAnalyzer\Test\Unit\Model\Service\PostStatCollector;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SuperMetrics\Client\Api\Data\PostInterface;
use SuperMetrics\PostAnalyzer\Api\Service\DateHelperInterface;
use SuperMetrics\PostAnalyzer\Model\Service\PostStatCollector\TotalPostsByWeek;

class TotalPostsByWeekTest extends TestCase
{
    /**
     * @var MockObject|DateHelperInterface
     */
    private $dateHelper;
    /**
     * @var MockObject|PostInterface
     */
    private $post;
    /**
     * @var \DateTime|MockObject
     */
    private $dateTime;

    private TotalPostsByWeek $postStatCollector;

    protected function setUp(): void
    {
        $this->dateHelper = $this->createMock(DateHelperInterface::class);

        $this->postStatCollector = new TotalPostsByWeek($this->dateHelper);

        $this->post = $this->createMock(PostInterface::class);
        $this->dateTime = $this->createMock(\DateTime::class);
    }

    public function testGetStatDescription(): void
    {
        self::assertEquals(
            'Total posts split by week number',
            $this->postStatCollector->getStatDescription()
        );
    }

    public function testAddPost(): void
    {
        $weekNumber = '11';
        $createdTime = '2012-12-12T12:12:12+00:00';
        $weekYear = '2012';
        $this->post
            ->expects(self::exactly(4))
            ->method('getCreatedTime')
            ->willReturn($createdTime);

        $this->dateHelper
            ->expects(self::exactly(4))
            ->method('getDateTime')
            ->with($createdTime)
            ->willReturn($this->dateTime);

        $this->dateHelper
            ->expects(self::exactly(4))
            ->method('getWeekNumberFromDate')
            ->with($this->dateTime)
            ->willReturn($weekNumber);

        $this->dateHelper
            ->expects(self::exactly(4))
            ->method('getWeekYearFromDate')
            ->with($this->dateTime)
            ->willReturn($weekYear);

        $data = [
            $weekYear => [
                $weekNumber => 2,
            ],
        ];

        $this->postStatCollector->addPost($this->post);
        $this->postStatCollector->addPost($this->post);
        self::assertEquals($data, $this->postStatCollector->getResult());
        $this->postStatCollector->removePost($this->post);
        $this->postStatCollector->removePost($this->post);
        $data = [
            $weekYear => [
                $weekNumber => 0,
            ],
        ];
        self::assertEquals($data, $this->postStatCollector->getResult());
    }
}
