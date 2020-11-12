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
use SuperMetrics\PostAnalyzer\Model\Service\PostStatCollector\PostsPerUserPerMonth;

class PostsPerUserPerMonthTest extends TestCase
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

    private PostsPerUserPerMonth $postStatCollector;

    protected function setUp(): void
    {
        $this->dateHelper = $this->createMock(DateHelperInterface::class);

        $this->postStatCollector = new PostsPerUserPerMonth($this->dateHelper);

        $this->post = $this->createMock(PostInterface::class);
        $this->dateTime = $this->createMock(\DateTime::class);
    }

    public function testGetStatDescription(): void
    {
        self::assertEquals(
            'Number of posts per user per month',
            $this->postStatCollector->getStatDescription()
        );
    }

    public function testAddPost(): void
    {
        $month = '12';
        $postFromId = '10';
        $postFromName = 'Firstname Lastname';
        $createdTime = '2012-12-12T12:12:12+00:00';
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
            ->method('getMonthFromDate')
            ->with($this->dateTime)
            ->willReturn($month);

        $this->post
            ->expects(self::exactly(4))
            ->method('getFromId')
            ->willReturn($postFromId);

        $this->post
            ->expects(self::once())
            ->method('getFromName')
            ->willReturn($postFromName);

        $users = [
            $postFromId => $postFromName,
        ];

        $data = [
            $postFromId => [
                $month => 1,
            ],
        ];

        $this->postStatCollector->addPost($this->post);
        self::assertEquals($users, $this->postStatCollector->getUsers());
        self::assertEquals($data[$postFromId], $this->postStatCollector->getNumberOfPostsPerMonthByUserId($postFromId));
        $result = [
            'user_name_by_user_id' => $users,
            'posts_per_user_per_month' => $data,
        ];
        self::assertEquals($result, $this->postStatCollector->getResult());
        $this->postStatCollector->addPost($this->post);
        $data[$postFromId][$month] = 2;
        self::assertEquals($data[$postFromId], $this->postStatCollector->getNumberOfPostsPerMonthByUserId($postFromId));
        $this->postStatCollector->removePost($this->post);
        $data[$postFromId][$month] = 1;
        self::assertEquals($data[$postFromId], $this->postStatCollector->getNumberOfPostsPerMonthByUserId($postFromId));
        $this->postStatCollector->removePost($this->post);
        $data[$postFromId][$month] = 0;
        self::assertEquals($data[$postFromId], $this->postStatCollector->getNumberOfPostsPerMonthByUserId($postFromId));
    }
}
