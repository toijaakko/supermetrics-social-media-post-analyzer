<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\PostAnalyzer\Api\Service;

use SuperMetrics\PostAnalyzer\Api\Data\PostCollectionInterface;

interface PostStatResultParserInterface
{
    public const RESULT_POST_COUNT_BY_MONTH = 'post_count_by_month';
    public const RESULT_USER_POST_COUNT_PER_MONTH = 'user_post_count_per_month';
    public const RESULT_AVERAGE_POST_LENGTH_BY_MONTH = 'average_post_length_by_month';
    public const RESULT_LONGEST_POST_BY_MONTH = 'longest_post_by_month';
    public const RESULT_POST_COUNT_BY_WEEK = 'post_count_by_week';
    public const RESULTS_BY_USER = 'results_by_user';

    /**
     * Parses and outputs results of post stat collectors
     */
    public function getResult(PostCollectionInterface $postCollection): array;
}
