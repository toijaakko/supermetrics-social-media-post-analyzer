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

use SuperMetrics\PostAnalyzer\Api\Service\DateHelperInterface;
use SuperMetrics\PostAnalyzer\Exception\MonthFormatCodeException;

class DateHelper implements DateHelperInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDateTime(string $date): \DateTime
    {
        return new \DateTime($date);
    }

    /**
     * {@inheritdoc}
     */
    public function getMonthFromDate(
        \DateTime $dateTime,
        string $monthFormatCode = self::WITH_LEADING_ZERO_NUMERICAL_MONTH_FORMAT_CODE
    ): string {
        if (!\in_array($monthFormatCode, [
            self::FULL_TEXTUAL_MONTH_FORMAT_CODE,
            self::SHORT_TEXTUAL_MONTH_FORMAT_CODE,
            self::WITH_LEADING_ZERO_NUMERICAL_MONTH_FORMAT_CODE,
            self::WITHOUT_LEADING_ZERO_NUMERICAL_MONTH_FORMAT_CODE,
        ], true)) {
            throw new MonthFormatCodeException(\sprintf('Invalid month format code \'%s\'.', $monthFormatCode));
        }

        return $dateTime->format($monthFormatCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getWeekNumberFromDate(\DateTime $dateTime): string
    {
        return $dateTime->format(self::WEEK_NUMBER_OF_YEAR_FORMAT_CODE);
    }

    /**
     * {@inheritdoc}
     */
    public function getWeekYearFromDate(\DateTime $dateTime): string
    {
        return $dateTime->format(self::WEEK_NUMBER_YEAR_FORMAT_CODE);
    }
}
