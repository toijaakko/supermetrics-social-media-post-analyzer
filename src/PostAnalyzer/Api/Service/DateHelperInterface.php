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

use SuperMetrics\PostAnalyzer\Exception\MonthFormatCodeException;

interface DateHelperInterface
{
    public const FULL_TEXTUAL_MONTH_FORMAT_CODE = 'F';
    public const WITH_LEADING_ZERO_NUMERICAL_MONTH_FORMAT_CODE = 'm';
    public const WITHOUT_LEADING_ZERO_NUMERICAL_MONTH_FORMAT_CODE = 'n';
    public const SHORT_TEXTUAL_MONTH_FORMAT_CODE = 'n';
    public const WEEK_NUMBER_OF_YEAR_FORMAT_CODE = 'W';
    public const WEEK_NUMBER_YEAR_FORMAT_CODE = 'o';

    public function getDateTime(string $date): \DateTime;

    /**
     * @throws MonthFormatCodeException
     */
    public function getMonthFromDate(\DateTime $dateTime, string $monthFormatCode = 'F'): string;

    public function getWeekNumberFromDate(\DateTime $dateTime): string;

    public function getWeekYearFromDate(\DateTime $dateTime): string;
}
