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
use SuperMetrics\PostAnalyzer\Model\Service\PostStatCollector\CharacterLengthByPostIdPerMonth;

class CharacterLengthByPostIdPerMonthTest extends TestCase
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

    private CharacterLengthByPostIdPerMonth $postStatCollector;

    protected function setUp(): void
    {
        $this->dateHelper = $this->createMock(DateHelperInterface::class);

        $this->postStatCollector = new CharacterLengthByPostIdPerMonth($this->dateHelper);

        $this->post = $this->createMock(PostInterface::class);
        $this->dateTime = $this->createMock(\DateTime::class);
    }

    public function testGetStatDescription(): void
    {
        self::assertEquals(
            'Character length per post id per month',
            $this->postStatCollector->getStatDescription()
        );
    }

    public function testAddPost(): void
    {
        $month = '12';
        $postId = '10';
        $createdTime = '2012-12-12T12:12:12+00:00';
        $this->post
            ->expects(self::exactly(2))
            ->method('getCreatedTime')
            ->willReturn($createdTime);

        $this->dateHelper
            ->expects(self::exactly(2))
            ->method('getDateTime')
            ->with($createdTime)
            ->willReturn($this->dateTime);

        $this->dateHelper
            ->expects(self::exactly(2))
            ->method('getMonthFromDate')
            ->with($this->dateTime)
            ->willReturn($month);

        $this->post
            ->expects(self::exactly(2))
            ->method('getId')
            ->willReturn($postId);

        $message = 'Message 12345';

        $this->post
            ->expects(self::once())
            ->method('getMessage')
            ->willReturn($message);

        $data = [
            $month => [
                $postId => \mb_strlen($message),
                ],
        ];

        $this->postStatCollector->addPost($this->post);
        self::assertEquals($data, $this->postStatCollector->getResult());
        $this->postStatCollector->removePost($this->post);
        self::assertEmpty(\array_filter($this->postStatCollector->getResult()));
    }
}
