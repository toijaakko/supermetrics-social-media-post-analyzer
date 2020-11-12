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

use SuperMetrics\Client\Api\Data\ResponseInterface;
use SuperMetrics\Client\Model\Data\Response\DataFactory;
use SuperMetrics\Client\Model\Data\Response\ErrorFactory;
use SuperMetrics\Client\Model\Data\Response\MetaFactory;

class ResponseFactory
{
    private DataFactory $dataFactory;

    private ErrorFactory $errorFactory;

    private MetaFactory $metaFactory;

    public function __construct(
        DataFactory $dataFactory,
        ErrorFactory $errorFactory,
        MetaFactory $metaFactory
    ) {
        $this->dataFactory = $dataFactory;
        $this->errorFactory = $errorFactory;
        $this->metaFactory = $metaFactory;
    }

    public function create(
        ?string $rawJsonResponseMessage
    ): ResponseInterface {
        return new Response($this->dataFactory, $this->errorFactory, $this->metaFactory, $rawJsonResponseMessage);
    }
}
