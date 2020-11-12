<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Model\Data;

use SuperMetrics\Client\Api\Data\PostInterface;

class Post implements PostInterface
{
    private ?string $id;
    private ?string $fromName;
    private ?string $fromId;
    private ?string $message;
    private ?string $type;
    private ?string $createdTime;

    /**
     * Post constructor.
     */
    public function __construct(
        ?string $id,
        ?string $fromName,
        ?string $fromId,
        ?string $message,
        ?string $type,
        ?string $createdTime
    ) {
        $this->id = $id;
        $this->fromName = $fromName;
        $this->fromId = $fromId;
        $this->message = $message;
        $this->type = $type;
        $this->createdTime = $createdTime;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setId(?string $id): PostInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFromName(): ?string
    {
        return $this->fromName;
    }

    /**
     * {@inheritdoc}
     */
    public function setFromName(?string $fromName): PostInterface
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFromId(): ?string
    {
        return $this->fromId;
    }

    public function setFromId(?string $fromId): PostInterface
    {
        $this->fromId = $fromId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage(?string $message): PostInterface
    {
        $this->message = $message;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(?string $type): PostInterface
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedTime(): ?string
    {
        return $this->createdTime;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedTime(?string $createdTime): PostInterface
    {
        $this->createdTime = $createdTime;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        $data = [
            self::FIELD_ID => $this->getId(),
            self::FIELD_FROM_NAME => $this->getFromName(),
            self::FIELD_FROM_ID => $this->getFromId(),
            self::FIELD_MESSAGE => $this->getMessage(),
            self::FIELD_TYPE => $this->getType(),
            self::FIELD_CREATED_TIME => $this->getCreatedTime(),
        ];

        return $data;
    }
}
