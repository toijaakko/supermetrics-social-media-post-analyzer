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
use SuperMetrics\Client\Api\Data\Response\DataInterface;
use SuperMetrics\Client\Model\Data\Response\DataFactory;

class DataTest extends TestCase
{
    private string $clientId;
    private string $token;
    /**
     * @var string[]
     */
    private array $posts;
    private ?DataInterface $dataModel;

    private ?DataInterface $nullDataModel;

    private ?DataInterface $emptyDataModel;
    private array $dataArray;
    private string $pageNumber;

    private DataFactory $dataFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dataFactory = new DataFactory();

        $this->clientId = '123234';
        $this->token = '3423432542';
        $this->pageNumber = '2';
        $this->posts = ['id' => '234j3o4'];
        $this->dataArray = [
            'client_id' => $this->clientId,
            'sl_token' => $this->token,
            'page' => $this->pageNumber,
            'posts' => $this->posts,
            ];

        $this->dataModel = $this->dataFactory->create($this->dataArray);
        $this->nullDataModel = null;
        $this->emptyDataModel = $this->dataFactory->create([]);
    }

    public function testGetRawData(): void
    {
        self::assertEquals($this->dataArray, $this->dataModel->getRawData());
        self::assertNull($this->nullDataModel);
        self::assertEmpty($this->emptyDataModel->getRawData());
    }

    public function testGetClientId(): void
    {
        self::assertEquals($this->clientId, $this->dataModel->getClientId());
        self::assertNull($this->nullDataModel);
        self::assertNull($this->emptyDataModel->getClientId());
    }

    public function testGetToken(): void
    {
        self::assertEquals($this->token, $this->dataModel->getToken());
        self::assertNull($this->nullDataModel);
        self::assertNull($this->emptyDataModel->getToken());
    }

    public function testGetPageNumber(): void
    {
        self::assertEquals($this->pageNumber, $this->dataModel->getPageNumber());
        self::assertNull($this->nullDataModel);
        self::assertNull($this->emptyDataModel->getPageNumber());
    }

    public function testGetPosts(): void
    {
        self::assertEquals($this->posts, $this->dataModel->getPosts());
        self::assertNull($this->nullDataModel);
        self::assertNull($this->emptyDataModel->getPosts());
    }
}
