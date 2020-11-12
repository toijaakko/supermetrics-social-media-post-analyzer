<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\PostAnalyzer\Model\Data;

use SuperMetrics\Client\Api\Data\PostInterface;
use SuperMetrics\PostAnalyzer\Api\Data\PostCollectionInterface;
use SuperMetrics\PostAnalyzer\Api\Service\PostStatCollectorPoolInterface;
use SuperMetrics\PostAnalyzer\Exception\NoSuchPostException;
use SuperMetrics\PostAnalyzer\Exception\PostAlreadyExistsException;
use SuperMetrics\PostAnalyzer\Exception\PostIdMissingException;
use SuperMetrics\PostAnalyzer\Exception\PostStatCollectorException;
use SuperMetrics\PostAnalyzer\Exception\UnableToAddPostException;

class PostCollection implements PostCollectionInterface
{
    /**
     * @var PostInterface[]
     */
    private array $posts = [];

    /**
     * @var PostStatCollectorPoolInterface
     */
    private $postStatCollectorPool;

    /**
     * PostCollection constructor.
     */
    public function __construct(
        PostStatCollectorPoolInterface $postStatCollectorPool
    ) {
        $this->postStatCollectorPool = $postStatCollectorPool;
    }

    /**
     * {@inheritdoc}
     */
    public function addPost(PostInterface $post): void
    {
        $postId = $post->getId();
        if (!$postId) {
            throw new PostIdMissingException(\sprintf('Unable to add post (ID \'%s\') to collection.', $postId));
        }
        if (isset($this->posts[$postId])) {
            throw new PostAlreadyExistsException(\sprintf('Unable to add post (ID \'%s\') to collection.', $postId));
        }
        $this->posts[$postId] = $post;
        $statCollectors = $this->postStatCollectorPool->getCollectors();
        foreach ($statCollectors as $statCollector) {
            try {
                $statCollector->addPost($post);
            } catch (PostStatCollectorException $e) {
                throw new UnableToAddPostException(\sprintf('Failed to add post. Reason: %s', $e->getMessage()));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removePostById(string $postId): void
    {
        if (!isset($this->posts[$postId])) {
            throw new NoSuchPostException(\sprintf('Unable to remove post (ID \'%s\' from collection.', $postId));
        }
        unset($this->posts[$postId]);
    }

    /**
     * {@inheritdoc}
     */
    public function getByPostId(string $postId): PostInterface
    {
        $post = $this->posts[$postId] ?? null;
        if (!$post) {
            throw new NoSuchPostException(\sprintf('No such post with ID \'%s\'.', $postId));
        }

        return $post;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatCollectorPool(): PostStatCollectorPoolInterface
    {
        return $this->postStatCollectorPool;
    }
}
