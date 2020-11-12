<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\PostAnalyzer\Test\Unit\Model\Service;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SuperMetrics\Client\Api\Data\PostInterface;
use SuperMetrics\PostAnalyzer\Api\Data\PostCollectionInterface;
use SuperMetrics\PostAnalyzer\Api\Service\PostStatCollectorPoolInterface;
use SuperMetrics\PostAnalyzer\Api\Service\PostStatResultParserInterface;
use SuperMetrics\PostAnalyzer\Model\Service\PostStatCollector\CharacterLengthByPostIdPerMonth;
use SuperMetrics\PostAnalyzer\Model\Service\PostStatCollector\PostsPerUserPerMonth;
use SuperMetrics\PostAnalyzer\Model\Service\PostStatCollector\TotalPostsByWeek;
use SuperMetrics\PostAnalyzer\Model\Service\PostStatResultParser;

class PostStatResultParserTest extends TestCase
{
    /**
     * @var MockObject|PostStatCollectorPoolInterface
     */
    private $postStatCollectorPool;

    private PostStatResultParser $postStatResult;
    /**
     * @var MockObject|PostCollectionInterface
     */
    private $postCollection;
    /**
     * @var MockObject|CharacterLengthByPostIdPerMonth
     */
    private $characterLengthCollector;
    /**
     * @var MockObject|TotalPostsByWeek
     */
    private $totalsByWeekCollector;
    /**
     * @var MockObject|PostsPerUserPerMonth
     */
    private $postsPerMonth;
    /**
     * @var MockObject|PostInterface
     */
    private $post;

    public function testGetJson(): void
    {
        $this->postCollection
            ->expects(self::once())
            ->method('getStatCollectorPool')
            ->willReturn($this->postStatCollectorPool);

        $collectors = [
            $this->characterLengthCollector,
            $this->totalsByWeekCollector,
            $this->postsPerMonth,
        ];

        $this->postStatCollectorPool
            ->expects(self::once())
            ->method('getCollectors')
            ->willReturn($collectors);

        $characterLengthByPostIdPerMonth = [
            '01' => [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
            ],
            '02' => [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
            ],
        ];
        $this->characterLengthCollector
            ->expects(self::once())
            ->method('getResult')
            ->willReturn($characterLengthByPostIdPerMonth);

        $result[PostStatResultParserInterface::RESULT_AVERAGE_POST_LENGTH_BY_MONTH] =
            [
                '01' => 3,
                '02' => 3,
            ];

        $this->postCollection
            ->expects(self::exactly(2))
            ->method('getByPostId')
            ->with('5')
            ->willReturn($this->post);

        $postData = ['id' => '5', 'message' => '12345'];
        $this->post
            ->expects(self::exactly(2))
            ->method('getData')
            ->willReturn($postData);

        $result[PostStatResultParserInterface::RESULT_LONGEST_POST_BY_MONTH] =
            [
                '01' => $postData,
                '02' => $postData,
            ];

        $totalPosts = [
            '01' => 11,
            '02' => 12,
        ];

        $totalByYear = [
            '2012' => $totalPosts,
        ];

        $this->totalsByWeekCollector
            ->expects(self::once())
            ->method('getResult')
            ->willReturn($totalByYear);

        $result[PostStatResultParserInterface::RESULT_POST_COUNT_BY_WEEK] = $totalByYear;

        $postsByMonth = $totalPosts;

        $users = [
            '2' => 'name2',
            '1' => 'name1',
        ];

        $this->postsPerMonth
            ->expects(self::once())
            ->method('getUsers')
            ->willReturn($users);

        $this->postsPerMonth
            ->expects(self::exactly(2))
            ->method('getNumberOfPostsPerMonthByUserId')
            ->withConsecutive(['1'], ['2'])
            ->willReturn($postsByMonth);

        $result[PostStatResultParserInterface::RESULTS_BY_USER] = [
            [
                PostInterface::FIELD_FROM_ID => '1',
                PostInterface::FIELD_FROM_NAME => 'name1',
                PostStatResultParserInterface::RESULT_USER_POST_COUNT_PER_MONTH => $postsByMonth,
            ],
            [
                PostInterface::FIELD_FROM_ID => '2',
                PostInterface::FIELD_FROM_NAME => 'name2',
                PostStatResultParser::RESULT_USER_POST_COUNT_PER_MONTH => $postsByMonth,
            ],
        ];

        $actualResult = $this->postStatResult->getResult($this->postCollection);

        self::assertEquals($result, $actualResult);
    }

    protected function setUp(): void
    {
        $this->postStatCollectorPool = $this->createMock(PostStatCollectorPoolInterface::class);
        $this->postCollection = $this->createMock(PostCollectionInterface::class);
        $this->postStatResult = new PostStatResultParser();

        $this->characterLengthCollector = $this->createMock(CharacterLengthByPostIdPerMonth::class);
        $this->totalsByWeekCollector = $this->createMock(TotalPostsByWeek::class);
        $this->postsPerMonth = $this->createMock(PostsPerUserPerMonth::class);
        $this->post = $this->createMock(PostInterface::class);
    }
}
