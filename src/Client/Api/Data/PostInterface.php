<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

namespace SuperMetrics\Client\Api\Data;

interface PostInterface
{
    public const FIELD_ID = 'id';
    public const FIELD_FROM_NAME = 'from_name';
    public const FIELD_FROM_ID = 'from_id';
    public const FIELD_MESSAGE = 'message';
    public const FIELD_TYPE = 'type';
    public const FIELD_CREATED_TIME = 'created_time';

    /**
     * Get post id
     */
    public function getId(): ?string;

    /**
     * Set post id
     *
     * @return PostInterface
     */
    public function setId(?string $id): self;

    /**
     * Get post from name
     */
    public function getFromName(): ?string;

    /**
     * Set post from name
     *
     * @return PostInterface
     */
    public function setFromName(?string $fromName): self;

    /**
     * Get post from id
     */
    public function getFromId(): ?string;

    /**
     * Set post from id
     *
     * @return PostInterface
     */
    public function setFromId(?string $fromId): self;

    /**
     * Get post message
     */
    public function getMessage(): ?string;

    /**
     * Set post message
     *
     * @return PostInterface
     */
    public function setMessage(?string $message): self;

    /**
     * Get post type
     */
    public function getType(): ?string;

    /**
     * Set post type
     *
     * @return PostInterface
     */
    public function setType(?string $type): self;

    /**
     * Get post created time
     */
    public function getCreatedTime(): ?string;

    /**
     * Set post created time
     *
     * @return PostInterface
     */
    public function setCreatedTime(?string $createdTime): self;

    /**
     * Get data with field as key
     *
     * @return array<string, mixed>
     */
    public function getData(): array;
}
