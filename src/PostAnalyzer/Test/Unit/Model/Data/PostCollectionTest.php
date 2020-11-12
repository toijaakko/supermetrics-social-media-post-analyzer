<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\PostAnalyzer\Test\Unit\Model\Data;

use PHPUnit\Framework\TestCase;
use SuperMetrics\Client\Api\Data\PostInterface;
use SuperMetrics\PostAnalyzer\Api\Service\PostStatCollectorInterface;
use SuperMetrics\PostAnalyzer\Api\Service\PostStatCollectorPoolInterface;
use SuperMetrics\PostAnalyzer\Exception\NoSuchPostException;
use SuperMetrics\PostAnalyzer\Exception\PostAlreadyExistsException;
use SuperMetrics\PostAnalyzer\Exception\PostIdMissingException;
use SuperMetrics\PostAnalyzer\Exception\PostStatCollectorException;
use SuperMetrics\PostAnalyzer\Exception\UnableToAddPostException;
use SuperMetrics\PostAnalyzer\Model\Data\PostCollection;

class PostCollectionTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|PostStatCollectorPoolInterface
     */
    private $postStatCollectorPool;

    private PostCollection $postCollection;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|PostInterface
     */
    private $post;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|PostStatCollectorInterface
     */
    private $postStatCollector;

    protected function setUp(): void
    {
        $this->postStatCollectorPool = $this->createMock(PostStatCollectorPoolInterface::class);
        $this->post = $this->createMock(PostInterface::class);
        $this->postStatCollector = $this->createMock(PostStatCollectorInterface::class);

        $this->postCollection = new PostCollection($this->postStatCollectorPool);
    }

    public function testAddPostMissingIdException(): void
    {
        $this->post
            ->expects(self::once())
            ->method('getId')
            ->willReturn(null);
        $this->expectException(PostIdMissingException::class);

        $this->postCollection->addPost($this->post);
    }

    public function testGetPostMissingException(): void
    {
        $this->expectException(NoSuchPostException::class);
        $this->expectExceptionMessage(\sprintf('No such post with ID \'%s\'.', '123'));

        $this->postCollection->getByPostId('123');
    }

    public function testRemovePostByIdMissingException(): void
    {
        $postId = '123';
        $this->expectException(NoSuchPostException::class);
        $this->expectExceptionMessage(\sprintf('Unable to remove post (ID \'%s\' from collection.', $postId));

        $this->postCollection->removePostById('123');
    }

    public function testAddPost(): void
    {
        $this->post
            ->expects(self::once())
            ->method('getId')
            ->willReturn('123');

        $this->postStatCollectorPool
            ->expects(self::once())
            ->method('getCollectors')
            ->willReturn([$this->postStatCollector, $this->postStatCollector]);

        $this->postStatCollector
            ->expects(self::exactly(2))
            ->method('addPost')
            ->with($this->post);

        $this->postCollection->addPost($this->post);
        self::assertEquals($this->post, $this->postCollection->getByPostId('123'));
        $this->postCollection->removePostById('123');
    }

    public function testAddPostPostAlreadyExists(): void
    {
        $postId = '123';
        $this->post
            ->expects(self::exactly(2))
            ->method('getId')
            ->willReturn($postId);

        $this->postStatCollectorPool
            ->expects(self::once())
            ->method('getCollectors')
            ->willReturn([$this->postStatCollector, $this->postStatCollector]);

        $this->postStatCollector
            ->expects(self::exactly(2))
            ->method('addPost')
            ->with($this->post);

        $this->postCollection->addPost($this->post);
        self::assertEquals($this->post, $this->postCollection->getByPostId('123'));
        $this->expectException(PostAlreadyExistsException::class);
        $this->expectExceptionMessage(\sprintf('Unable to add post (ID \'%s\') to collection.', $postId));
        $this->postCollection->addPost($this->post);
    }

    public function testAddPostCollectorPoolException(): void
    {
        $this->post
            ->expects(self::once())
            ->method('getId')
            ->willReturn('123');

        $this->postStatCollectorPool
            ->expects(self::once())
            ->method('getCollectors')
            ->willReturn([$this->postStatCollector, $this->postStatCollector]);

        $exception = $this->createMock(PostStatCollectorException::class);

        $this->postStatCollector
            ->expects(self::once())
            ->method('addPost')
            ->with($this->post)
            ->willThrowException($exception);

        $this->expectException(UnableToAddPostException::class);
        $this->postCollection->addPost($this->post);
    }

    public function testGetStatCollectorPool(): void
    {
        self::assertEquals($this->postStatCollectorPool, $this->postCollection->getStatCollectorPool());
    }
}
