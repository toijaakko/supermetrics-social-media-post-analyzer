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

use SuperMetrics\Client\Api\Data\Response\DataInterface;
use SuperMetrics\Client\Api\Data\Response\ErrorInterface;
use SuperMetrics\Client\Api\Data\Response\MetaInterface;
use SuperMetrics\Client\Api\Data\ResponseInterface;
use SuperMetrics\Client\Model\Data\Response\DataFactory;
use SuperMetrics\Client\Model\Data\Response\ErrorFactory;
use SuperMetrics\Client\Model\Data\Response\MetaFactory;

class Response implements ResponseInterface
{
    private ?string $rawResponseMessage;

    private DataFactory $dataFactory;

    private ErrorFactory $errorFactory;

    private MetaFactory $metaFactory;
    /**
     * @var DataInterface|null
     */
    private $data;
    /**
     * @var ErrorInterface|null
     */
    private $error;
    /**
     * @var MetaInterface|null
     */
    private $meta;

    public function __construct(
        DataFactory $dataFactory,
        ErrorFactory $errorFactory,
        MetaFactory $metaFactory,
        ?string $rawResponseMessage
    ) {
        $this->dataFactory = $dataFactory;
        $this->errorFactory = $errorFactory;
        $this->metaFactory = $metaFactory;
        $this->rawResponseMessage = $rawResponseMessage;
    }

    public function getRawResponse(): string
    {
        return $this->rawResponseMessage;
    }

    public function getData(): ?DataInterface
    {
        if (!isset($this->data)) {
            $response = \json_decode($this->rawResponseMessage, true);
            $data = \is_array($response) ? $response[self::FIELD_DATA] ?? null : null;
            if (!$data || !\is_array($data)) {
                return null;
            }
            $this->data = $this->dataFactory->create($data);
        }

        return $this->data;
    }

    public function getError(): ?ErrorInterface
    {
        if (!isset($this->error)) {
            $response = \json_decode($this->rawResponseMessage, true);
            $error = \is_array($response) ? $response[self::FIELD_ERROR] ?? null : null;
            if (!$error || !\is_array($error)) {
                return null;
            }

            $this->error = $this->errorFactory->create($error);
        }

        return $this->error;
    }

    public function getMeta(): ?MetaInterface
    {
        if (!isset($this->meta)) {
            $response = \json_decode($this->rawResponseMessage, true);
            $meta = \is_array($response) ? $response[self::FIELD_META] ?? null : null;
            if (!$meta || !\is_array($meta)) {
                return null;
            }
            $this->meta = $this->metaFactory->create($meta);
        }

        return $this->meta;
    }
}
