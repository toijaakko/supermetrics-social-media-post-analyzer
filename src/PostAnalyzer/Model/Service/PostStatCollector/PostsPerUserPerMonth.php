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

class PostsPerUserPerMonth implements PostStatCollectorInterface
{
    /**
     * Number of posts by user per each month
     *
     * @var array<string, array<string, int>>
     */
    protected array $postsPerUserIdPerMonth;

    /**
     * User name by user id
     *
     * @var array<string, string>
     */
    protected array $userNameByUserId;

    /**
     * @var DateHelperInterface
     */
    protected $dateHelper;

    /**
     * PostsPerUserPerMonth constructor.
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
        return 'Number of posts per user per month';
    }

    /**
     * {@inheritdoc}
     */
    public function addPost(PostInterface $post): void
    {
        $createdTime = $this->dateHelper->getDateTime($post->getCreatedTime());

        $month = $this->dateHelper->getMonthFromDate($createdTime);

        $userId = $post->getFromId();

        $userName = $this->userNameByUserId[$userId] ?? null;
        if (!$userName) {
            $this->userNameByUserId[$userId] = $post->getFromName();
        }

        if (isset($this->postsPerUserIdPerMonth[$userId][$month])) {
            ++$this->postsPerUserIdPerMonth[$userId][$month];
        } else {
            $this->postsPerUserIdPerMonth[$userId][$month] = 1;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removePost(PostInterface $post): void
    {
        $createdTime = $this->dateHelper->getDateTime($post->getCreatedTime());

        $month = $this->dateHelper->getMonthFromDate($createdTime);

        $userId = $post->getFromId();

        if (isset($this->postsPerUserIdPerMonth[$userId][$month])) {
            --$this->postsPerUserIdPerMonth[$userId][$month];
        }
    }

    /**
     * Return array of users
     *
     * @return array
     */
    public function getResult()
    {
        return [
            'user_name_by_user_id' => $this->userNameByUserId,
            'posts_per_user_per_month' => $this->postsPerUserIdPerMonth,
        ];
    }

    /**
     * Return array of usernames by user id as key
     *
     * @return array<string, string>
     */
    public function getUsers(): array
    {
        return $this->userNameByUserId;
    }

    /**
     * Return username by user id
     *
     * @return array<string, int>|null
     */
    public function getNumberOfPostsPerMonthByUserId(string $userId): ?array
    {
        return $this->postsPerUserIdPerMonth[$userId] ?? null;
    }
}
