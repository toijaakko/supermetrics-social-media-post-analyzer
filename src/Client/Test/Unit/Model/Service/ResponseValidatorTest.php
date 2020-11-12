<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Test\Unit\Model\Service;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SuperMetrics\Client\Api\Data\Response\DataInterface;
use SuperMetrics\Client\Api\Data\Response\ErrorInterface;
use SuperMetrics\Client\Api\Data\ResponseInterface;
use SuperMetrics\Client\Exception\ResponseValidationException;
use SuperMetrics\Client\Model\Service\ResponseValidator;

class ResponseValidatorTest extends TestCase
{
    /**
     * @var MockObject|ResponseInterface
     */
    private $response;

    private ResponseValidator $responseValidator;
    /**
     * @var MockObject|DataInterface
     */
    private $dataModel;
    /**
     * @var MockObject|ErrorInterface
     */
    private $error;

    protected function setUp(): void
    {
        parent::setUp();

        $this->response = $this->createMock(ResponseInterface::class);
        $this->error = $this->createMock(ErrorInterface::class);
        $this->dataModel = $this->createMock(DataInterface::class);

        $this->responseValidator = new ResponseValidator();
    }

    public function responseDataProvider(): array
    {
        return [
            [
                'error' => null,
                'data' => ['token' => '1234'],
                'exception' => false,
            ],
            [
                'error' => ['message' => 'INVALID_CLIENT_ID'],
                'data' => null,
                'exception' => true,
            ],
            [
                'error' => ['code' => 'Invalid SL Token'],
                'data' => null,
                'exception' => true,
            ],
            [
                'error' => null,
                'data' => null,
                'exception' => true,
            ],
        ];
    }

    /**
     * @dataProvider responseDataProvider
     */
    public function testValidate(?array $error, ?array $data, bool $exception): void
    {
        $this->response
            ->expects(self::once())
            ->method('getError')
            ->willReturn($error ? $this->error : null);

        $this->error
            ->expects($error ? self::exactly(2) : self::never())
            ->method('getErrorCode')
            ->willReturn($error['code'] ?? null);

        $this->error
            ->expects($error ? self::once() : self::never())
            ->method('getErrorMessage')
            ->willReturn($error['message'] ?? null);

        $this->error
            ->expects($error ? self::once() : self::never())
            ->method('getErrorDescription')
            ->willReturn($error['description'] ?? null);

        $this->response
            ->expects(!$error ? self::once() : self::never())
            ->method('getData')
            ->willReturn($data ? $this->dataModel : null);

        if ($exception) {
            $this->expectException(ResponseValidationException::class);
            if ($error) {
                $errorCode = $error['code'] ?? null;
                $exceptionMessage = \sprintf(
                    'Error in response. Error code: \'%s\'. Error message: \'%s\'. Error description: \'%s\'',
                    $errorCode,
                    $error['message'] ?? null,
                    $error['description'] ?? null,
                );
                $this->expectExceptionMessage($exceptionMessage);
                $errorCode = 'Invalid SL Token' === $errorCode ? 1 : 0;
                $this->expectExceptionCode($errorCode);
            } elseif (!$data) {
                $this->expectExceptionMessage('No data in response.');
            }
        }

        $this->responseValidator->validate($this->response);
    }
}
