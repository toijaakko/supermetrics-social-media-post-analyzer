<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Test\Unit\Model\Data;

use PHPUnit\Framework\TestCase;
use SuperMetrics\Client\Api\Data\PostInterface;
use SuperMetrics\Client\Model\Data\PostFactory;

class PostTest extends TestCase
{
    private ?string $id;
    private ?string $fromName;
    private ?string $fromId;
    private ?string $message;
    private ?string $type;
    private ?string $createdTime;

    private PostInterface $post;

    private PostFactory $postFactory;

    private PostInterface $nullPost;

    protected function setUp(): void
    {
        parent::setUp();

        $this->id = 'post123456789';
        $this->fromName = 'Firstname Lastname';
        $this->fromId = 'user';
        $this->message = 'name@email.com';
        $this->type = 'type';
        $this->createdTime = '2012-12-12T12:12:12+00:00';

        $this->postFactory = new PostFactory();

        $this->post = $this->postFactory->create(
            $this->id,
            $this->fromName,
            $this->fromId,
            $this->message,
            $this->type,
            $this->createdTime,
        );

        $this->nullPost = $this->postFactory
            ->create(null, null, null, null, null, null);
    }

    public function testId(): void
    {
        self::assertEquals($this->id, $this->post->getId());
        self::assertSame($this->post, $this->post->setId(null));
        self::assertNull($this->post->getId());
        self::assertSame($this->post, $this->post->setId($this->id));
        self::assertEquals($this->id, $this->post->getId());
        self::assertNull($this->nullPost->getId());
    }

    public function testFromName(): void
    {
        self::assertEquals($this->fromName, $this->post->getFromName());
        self::assertSame($this->post, $this->post->setFromName(null));
        self::assertNull($this->post->getFromName());
        self::assertSame($this->post, $this->post->setFromName($this->fromName));
        self::assertEquals($this->fromName, $this->post->getFromName());
        self::assertNull($this->nullPost->getFromName());
    }

    public function testFromId(): void
    {
        self::assertEquals($this->fromId, $this->post->getFromId());
        self::assertSame($this->post, $this->post->setFromId(null));
        self::assertNull($this->post->getFromId());
        self::assertSame($this->post, $this->post->setFromId($this->fromId));
        self::assertEquals($this->fromId, $this->post->getFromId());
        self::assertNull($this->nullPost->getFromId());
    }

    public function testMessage(): void
    {
        self::assertEquals($this->message, $this->post->getMessage());
        self::assertSame($this->post, $this->post->setMessage(null));
        self::assertNull($this->post->getMessage());
        self::assertSame($this->post, $this->post->setMessage($this->message));
        self::assertEquals($this->message, $this->post->getMessage());
        self::assertNull($this->nullPost->getMessage());
    }

    public function testType(): void
    {
        self::assertEquals($this->type, $this->post->getType());
        self::assertSame($this->post, $this->post->setType(null));
        self::assertNull($this->post->getType());
        self::assertSame($this->post, $this->post->setType($this->type));
        self::assertEquals($this->type, $this->post->getType());
        self::assertNull($this->nullPost->getType());
    }

    public function testCreatedTime(): void
    {
        self::assertEquals($this->createdTime, $this->post->getCreatedTime());
        self::assertSame($this->post, $this->post->setCreatedTime(null));
        self::assertNull($this->post->getCreatedTime());
        self::assertSame($this->post, $this->post->setCreatedTime($this->createdTime));
        self::assertEquals($this->createdTime, $this->post->getCreatedTime());
        self::assertNull($this->nullPost->getCreatedTime());
    }

    public function testGetData(): void
    {
        $data = [
            'id' => $this->id,
            'from_name' => $this->fromName,
            'from_id' => $this->fromId,
            'message' => $this->message,
            'type' => $this->type,
            'created_time' => $this->createdTime,
        ];

        self::assertEquals($data, $this->post->getData());
    }
}
