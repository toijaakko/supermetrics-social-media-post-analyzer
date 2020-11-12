<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\PostAnalyzer\Model\Service\PostStatCollector;

use SuperMetrics\Client\Api\Data\PostInterface;
use SuperMetrics\PostAnalyzer\Api\Service\DateHelperInterface;
use SuperMetrics\PostAnalyzer\Api\Service\PostStatCollectorInterface;

class TotalPostsByWeek implements PostStatCollectorInterface
{
    /**
     * Number of posts by week number
     *
     * @var array<string, array<string, int>>
     */
    protected array $totalPostsByYearAndWeekNumber;

    /**
     * @var DateHelperInterface
     */
    protected $dateHelper;

    /**
     * TotalPostsByWeek constructor.
     */
    public function __construct(
        DateHelperInterface $dateHelper
    ) {
        $this->dateHelper = $dateHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatDescription(): string
    {
        return 'Total posts split by week number';
    }

    /**
     * {@inheritdoc}
     */
    public function addPost(PostInterface $post): void
    {
        $createdTime = $this->dateHelper->getDateTime($post->getCreatedTime());

        $weekNumber = $this->dateHelper->getWeekNumberFromDate($createdTime);
        $weekYear = $this->dateHelper->getWeekYearFromDate($createdTime);

        if (isset($this->totalPostsByYearAndWeekNumber[$weekYear][$weekNumber])) {
            ++$this->totalPostsByYearAndWeekNumber[$weekYear][$weekNumber];
        } else {
            $this->totalPostsByYearAndWeekNumber[$weekYear][$weekNumber] = 1;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removePost(PostInterface $post): void
    {
        $createdTime = $this->dateHelper->getDateTime($post->getCreatedTime());

        $weekNumber = $this->dateHelper->getWeekNumberFromDate($createdTime);
        $weekYear = $this->dateHelper->getWeekYearFromDate($createdTime);

        if (isset($this->totalPostsByYearAndWeekNumber[$weekYear][$weekNumber])) {
            --$this->totalPostsByYearAndWeekNumber[$weekYear][$weekNumber];
        }
    }

    /**
     * Return number of posts in array of week years and week numbers
     *
     * @return array<string, array<string, int>>
     */
    public function getResult()
    {
        return $this->totalPostsByYearAndWeekNumber;
    }
}
