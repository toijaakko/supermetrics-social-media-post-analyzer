<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Model\Service;

use SuperMetrics\Client\Api\Data\PostInterface;
use SuperMetrics\Client\Api\Data\ResponseInterface;
use SuperMetrics\Client\Api\Service\ResponseParserInterface;
use SuperMetrics\Client\Exception\ResponseValidationException;
use SuperMetrics\Client\Model\Data\PostFactory;

class ResponseParser implements ResponseParserInterface
{
    private PostFactory $postFactory;

    public function __construct(
        PostFactory $postFactory
    ) {
        $this->postFactory = $postFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getToken(ResponseInterface $response): string
    {
        $data = $response->getData();

        $token = $data ? $data->getToken() : null;
        if (!$token) {
            throw new ResponseValidationException(\sprintf('No token in response. Raw message: \'%s\'.', $response->getRawResponse()));
        }

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function getPosts(ResponseInterface $response): array
    {
        $data = $response->getData();

        $postsData = $data ? $data->getPosts() : null;

        if (!$postsData) {
            throw new ResponseValidationException(\sprintf('No posts in response. Raw message: \'%s\'.', $response->getRawResponse()));
        }

        $posts = [];
        foreach ($postsData as $postData) {
            $id = $postData[PostInterface::FIELD_ID] ?? null;
            $fromName = $postData[PostInterface::FIELD_FROM_NAME] ?? null;
            $fromId = $postData[PostInterface::FIELD_FROM_ID] ?? null;
            $message = $postData[PostInterface::FIELD_MESSAGE] ?? null;
            $type = $postData[PostInterface::FIELD_TYPE] ?? null;
            $createdAt = $postData[PostInterface::FIELD_CREATED_TIME] ?? null;

            $posts[] = $this->postFactory->create($id, $fromName, $fromId, $message, $type, $createdAt);
        }

        return $posts;
    }
}
