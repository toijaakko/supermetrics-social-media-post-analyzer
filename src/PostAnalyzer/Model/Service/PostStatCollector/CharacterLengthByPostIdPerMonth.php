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

class CharacterLengthByPostIdPerMonth implements PostStatCollectorInterface
{
    /**
     * Character length by array by month key and by post id
     *
     * @var array<string, array<string, int>>
     */
    protected array $characterLengthByPostIdPerMonth;

    /**
     * @var DateHelperInterface
     */
    protected $dateHelper;

    /**
     * CharacterLengthByPostIdPerMonth constructor.
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
        return 'Character length per post id per month';
    }

    /**
     * {@inheritdoc}
     */
    public function addPost(PostInterface $post): void
    {
        $createdTime = $this->dateHelper->getDateTime($post->getCreatedTime());

        $month = $this->dateHelper->getMonthFromDate($createdTime);

        $postId = $post->getId();

        if ($postId) {
            $this->characterLengthByPostIdPerMonth[$month][$postId] = \mb_strlen((string) $post->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removePost(PostInterface $post): void
    {
        $postId = $post->getId();

        $createdTime = $this->dateHelper->getDateTime($post->getCreatedTime());

        $month = $this->dateHelper->getMonthFromDate($createdTime);

        unset($this->characterLengthByPostIdPerMonth[$month][$postId]);
    }

    /**
     * Return array of months of post ids and their message character length
     *
     * @return array
     */
    public function getResult()
    {
        return $this->characterLengthByPostIdPerMonth;
    }
}
