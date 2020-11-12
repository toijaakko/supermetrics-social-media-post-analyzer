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
use SuperMetrics\Client\Api\Data\Response\MetaInterface;
use SuperMetrics\Client\Model\Data\Response\MetaFactory;

class MetaTest extends TestCase
{
    private MetaFactory $metaFactory;
    private string $requestId;
    /**
     * @var string[]
     */
    private array $rawMetaArray;

    private ?MetaInterface $metaModel;

    private ?MetaInterface $nullMetaModel;

    private ?MetaInterface $emptyMetaModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->metaFactory = new MetaFactory();

        $this->requestId = '1324';

        $this->rawMetaArray = [
            'request_id' => $this->requestId,
            ];

        $this->metaModel = $this->metaFactory->create($this->rawMetaArray);
        $this->nullMetaModel = null;
        $this->emptyMetaModel = $this->metaFactory->create([]);
    }

    public function testGetRawMeta(): void
    {
        self::assertEquals($this->rawMetaArray, $this->metaModel->getRawMeta());
        self::assertNull($this->nullMetaModel);
        self::assertEmpty($this->emptyMetaModel->getRawMeta());
    }

    public function testGetRequestId(): void
    {
        self::assertEquals($this->requestId, $this->metaModel->getRequestId());
        self::assertNull($this->nullMetaModel);
        self::assertNull($this->emptyMetaModel->getRequestId());
    }
}
