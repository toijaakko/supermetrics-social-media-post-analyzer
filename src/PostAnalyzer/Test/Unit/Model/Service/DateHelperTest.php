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

use PHPUnit\Framework\TestCase;
use SuperMetrics\PostAnalyzer\Api\Service\DateHelperInterface;
use SuperMetrics\PostAnalyzer\Exception\MonthFormatCodeException;
use SuperMetrics\PostAnalyzer\Model\Service\DateHelper;

class DateHelperTest extends TestCase
{
    private DateHelper $dateHelper;
    /**
     * @var \DateTime|\PHPUnit\Framework\MockObject\MockObject
     */
    private $dateTime;

    protected function setUp(): void
    {
        $this->dateHelper = new DateHelper();
        $this->dateTime = $this->createMock(\DateTime::class);
    }

    public function testGetDateTime(): void
    {
        $date = '2012-12-12T12:12:12+00:00';
        self::assertInstanceOf(\DateTime::class, $this->dateHelper->getDateTime($date));
    }

    public function monthFormatCodeDataProvider(): array
    {
        return [
            [
                'format_code' => 'm',
                'is_exception' => false,
            ],
            [
                'format_code' => 'n',
                'is_exception' => false,
            ],
            [
                'format_code' => 'F',
                'is_exception' => false,
            ],
            [
                'format_code' => 'n',
                'is_exception' => false,
            ],
            [
                'format_code' => 'o',
                'is_exception' => true,
            ],
            [
                'format_code' => 'W',
                'is_exception' => true,
            ],
        ];
    }

    /**
     * @dataProvider monthFormatCodeDataProvider
     */
    public function testGetMonthFromDate(
        string $formatCode,
        bool $isException
    ): void {
        if ($isException) {
            $this->expectException(MonthFormatCodeException::class);
            $this->expectExceptionMessage(\sprintf('Invalid month format code \'%s\'.', $formatCode));
        }

        $month = '12';

        $this->dateTime
            ->expects($isException ? self::never() : self::once())
            ->method('format')
            ->with($formatCode)
            ->willReturn($month);

        $result = $this->dateHelper->getMonthFromDate($this->dateTime, $formatCode);
        if (!$isException) {
            self::assertEquals($month, $result);
        }
    }

    public function testGetWeekNumberFromDate(): void
    {
        $weekNumber = '12';

        $this->dateTime
            ->expects(self::once())
            ->method('format')
            ->with(DateHelperInterface::WEEK_NUMBER_OF_YEAR_FORMAT_CODE)
            ->willReturn($weekNumber);

        self::assertEquals($weekNumber, $this->dateHelper->getWeekNumberFromDate($this->dateTime));
    }

    public function testGetWeekYearFromDate(): void
    {
        $weekYear = '2012';

        $this->dateTime
            ->expects(self::once())
            ->method('format')
            ->with(DateHelperInterface::WEEK_NUMBER_YEAR_FORMAT_CODE)
            ->willReturn($weekYear);

        self::assertEquals($weekYear, $this->dateHelper->getWeekYearFromDate($this->dateTime));
    }
}
