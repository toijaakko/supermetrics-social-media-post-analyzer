<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Test\Unit\Model\Data\Response;

use PHPUnit\Framework\TestCase;
use SuperMetrics\Client\Api\Data\Response\ErrorInterface;
use SuperMetrics\Client\Model\Data\Response\ErrorFactory;

class ErrorTest extends TestCase
{
    private ErrorFactory $errorFactory;
    /**
     * @var ErrorInterface|null
     */
    private $errorModel;
    /**
     * @var ErrorInterface|null
     */
    private $nullErrorModel;
    /**
     * @var ErrorInterface|null
     */
    private $emptyErrorModel;
    private array $errorArray;
    private string $code;
    private string $message;
    private string $description;

    protected function setUp(): void
    {
        parent::setUp();

        $this->errorFactory = new ErrorFactory();

        $this->code = '1';
        $this->message = 'ENDPOINT_NOT_FOUND';
        $this->description = 'Endpoint not found.';

        $this->errorArray = [
            'code' => $this->code,
            'message' => $this->message,
            'description' => $this->description,
            ];

        $this->errorModel = $this->errorFactory->create($this->errorArray);
        $this->nullErrorModel = null;
        $this->emptyErrorModel = $this->errorFactory->create([]);
    }

    public function testGetRawError(): void
    {
        self::assertEquals($this->errorArray, $this->errorModel->getRawError());
        self::assertNull($this->nullErrorModel);
        self::assertEmpty($this->emptyErrorModel->getRawError());
    }

    public function testGetErrorCode(): void
    {
        self::assertEquals($this->code, $this->errorModel->getErrorCode());
        self::assertNull($this->nullErrorModel);
        self::assertNull($this->emptyErrorModel->getErrorCode());
    }

    public function testGetErrorMessage(): void
    {
        self::assertEquals($this->message, $this->errorModel->getErrorMessage());
        self::assertNull($this->nullErrorModel);
        self::assertNull($this->emptyErrorModel->getErrorMessage());
    }

    public function testGetErrorDescription(): void
    {
        self::assertEquals($this->description, $this->errorModel->getErrorDescription());
        self::assertNull($this->nullErrorModel);
        self::assertNull($this->emptyErrorModel->getErrorDescription());
    }
}
