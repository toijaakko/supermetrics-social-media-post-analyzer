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
use SuperMetrics\Client\Api\Config\ConfigurationInterface;
use SuperMetrics\Client\Api\Data\PostInterface;
use SuperMetrics\Client\Api\Data\Response\DataInterface;
use SuperMetrics\Client\Api\Data\ResponseInterface;
use SuperMetrics\Client\Exception\ResponseValidationException;
use SuperMetrics\Client\Model\Data\PostFactory;
use SuperMetrics\Client\Model\Service\ResponseParser;

class ResponseParserTest extends TestCase
{
    /**
     * @var MockObject|ConfigurationInterface
     */
    private $configuration;

    private ResponseParser $responseParser;
    /**
     * @var MockObject|ResponseInterface
     */
    private $response;
    /**
     * @var MockObject|PostFactory
     */
    private $postFactory;
    /**
     * @var MockObject|PostInterface
     */
    private $post;
    /**
     * @var MockObject|DataInterface
     */
    private $responseData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->configuration = $this->createMock(ConfigurationInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->postFactory = $this->createMock(PostFactory::class);
        $this->post = $this->createMock(PostInterface::class);
        $this->responseData = $this->createMock(DataInterface::class);

        $this->responseParser = new ResponseParser($this->postFactory);
    }

    public function testGetEmptyBody(): void
    {
        $this->response
            ->expects(self::once())
            ->method('getData')
            ->willReturn(null);

        $this->expectException(ResponseValidationException::class);

        $this->responseParser->getToken($this->response);
    }

    public function testGetEmptyData(): void
    {
        $this->response
            ->expects(self::once())
            ->method('getData')
            ->willReturn(null);

        $this->expectException(ResponseValidationException::class);

        $this->responseParser->getPosts($this->response);
    }

    /**
     * @return array<int, array<string, string|null>>
     */
    public function tokenDataProvider(): array
    {
        return [
            [
                'token' => '1234567',
            ],
            [
                'token' => null,
            ],
        ];
    }

    /**
     * @param string $token
     * @dataProvider tokenDataProvider
     */
    public function testGetToken(?string $token): void
    {
        $this->response
            ->expects(self::once())
            ->method('getData')
            ->willReturn($this->responseData);

        $this->responseData
            ->expects(self::once())
            ->method('getToken')
            ->willReturn($token);

        if (!$token) {
            $this->expectException(ResponseValidationException::class);
        }

        $result = $this->responseParser->getToken($this->response);

        if ($token) {
            self::assertEquals($token, $result);
        }
    }

    /**
     * @return array<int, array<string, array<int, array<string, string|null>>|null>>
     */
    public function postDataProvider(): array
    {
        return [
            [
                'posts' => [
                    [
                        'id' => null,
                        'fromName' => null,
                        'fromId' => null,
                        'message' => null,
                        'type' => null,
                        'createdTime' => null,
                    ],
                    [
                        'id' => '123',
                        'fromName' => 'Firstname Lastname',
                        'fromId' => '456',
                        'message' => 'Post message',
                        'type' => 'type',
                        'createdTime' => '2012-12-12T12:12:12+00:00',
                    ],
                ],
            ],
            [
                'posts' => null,
            ],
        ];
    }

    /**
     * @dataProvider postDataProvider
     */
    public function testGetPosts(?array $posts): void
    {
        $this->response
            ->expects(self::once())
            ->method('getData')
            ->willReturn($this->responseData);

        $this->responseData
            ->expects(self::once())
            ->method('getPosts')
            ->willReturn($posts);

        if (!$posts) {
            $this->expectException(ResponseValidationException::class);
        }

        $this->postFactory
            ->expects($posts ? self::exactly(\count($posts)) : self::never())
            ->method('create')
            ->withAnyParameters()
            ->willReturn($this->post);

        $result = $this->responseParser->getPosts($this->response);

        if ($posts) {
            foreach ($result as $post) {
                self::assertEquals($this->post, $post);
            }
        }
    }
}
