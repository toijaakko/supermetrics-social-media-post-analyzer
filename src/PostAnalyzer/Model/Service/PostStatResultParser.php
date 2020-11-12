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

use SuperMetrics\Client\Api\Data\PostInterface;
use SuperMetrics\PostAnalyzer\Api\Data\PostCollectionInterface;
use SuperMetrics\PostAnalyzer\Api\Service\PostStatCollectorInterface;
use SuperMetrics\PostAnalyzer\Api\Service\PostStatResultParserInterface;
use SuperMetrics\PostAnalyzer\Model\Service\PostStatCollector\CharacterLengthByPostIdPerMonth;
use SuperMetrics\PostAnalyzer\Model\Service\PostStatCollector\PostsPerUserPerMonth;
use SuperMetrics\PostAnalyzer\Model\Service\PostStatCollector\TotalPostsByWeek;

class PostStatResultParser implements PostStatResultParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function getResult(
        PostCollectionInterface $postCollection
    ): array {
        $postStatCollectorPool = $postCollection->getStatCollectorPool();
        $results = [];
        foreach ($postStatCollectorPool->getCollectors() as $statCollector) {
            $this->collectResults($statCollector, $postCollection, $results);
        }

        return $results;
    }

    private function collectResults(
        PostStatCollectorInterface $postStatCollector,
        PostCollectionInterface $postCollection,
        array &$results
    ) {
        if ($postStatCollector instanceof CharacterLengthByPostIdPerMonth) {
            $characterLengthByPostIdPerMonth = $postStatCollector->getResult();
            $averagePostLengthByMonth = [];
            $longestPostByMonth = [];
            foreach ($characterLengthByPostIdPerMonth as $month => $charactersByPostId) {
                $averagePostLengthByMonth[$month] = $this->getAverage($charactersByPostId);
                $longestPostByPostId = \array_keys($charactersByPostId, \max($charactersByPostId), true)[0] ?? null;
                $longestPostByMonth[$month] = $longestPostByPostId ? $postCollection
                    ->getByPostId((string) $longestPostByPostId)->getData() : null;
            }
            $this->sortNatural($averagePostLengthByMonth);
            $this->sortNatural($longestPostByMonth);

            $results[PostStatResultParserInterface::RESULT_AVERAGE_POST_LENGTH_BY_MONTH] = $averagePostLengthByMonth;
            $results[PostStatResultParserInterface::RESULT_LONGEST_POST_BY_MONTH] = $longestPostByMonth;
        } elseif ($postStatCollector instanceof TotalPostsByWeek) {
            $totals = $postStatCollector->getResult();
            foreach ($totals as $year => &$weeks) {
                $this->sortNatural($weeks);
            }
            unset($weeks);
            $this->sortNatural($totals);
            $results[PostStatResultParserInterface::RESULT_POST_COUNT_BY_WEEK] = $totals;
        } elseif ($postStatCollector instanceof PostsPerUserPerMonth) {
            $users = $postStatCollector->getUsers();
            $this->sortNatural($users);
            foreach ($users as $userId => $userName) {
                $userId = (string) $userId;
                $postsByMonth = $postStatCollector->getNumberOfPostsPerMonthByUserId($userId);
                if ($postsByMonth) {
                    $this->sortNatural($postsByMonth);
                    $userPostStats = [];
                    $userPostStats[PostInterface::FIELD_FROM_ID] = $userId;
                    $userPostStats[PostInterface::FIELD_FROM_NAME] = $userName;

                    $userPostStats[PostStatResultParserInterface::RESULT_USER_POST_COUNT_PER_MONTH] = $postsByMonth;
                    $results[PostStatResultParserInterface::RESULTS_BY_USER][] = $userPostStats;
                }
            }
        }
    }

    private function sortNatural(array &$array): void
    {
        \ksort($array, SORT_NATURAL | SORT_ASC);
    }

    private function getAverage(array $array): int
    {
        return (int) \round(\array_sum($array) / \count($array));
    }
}
