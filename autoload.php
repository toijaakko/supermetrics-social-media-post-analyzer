<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

require_once __DIR__ . '/vendor/autoload.php';

use SuperMetrics\Client\Model\Config\Configuration;
use SuperMetrics\Client\Model\Config\DotEnvReader;
use SuperMetrics\Client\Model\Data\PostFactory;
use SuperMetrics\Client\Model\Data\RequestFactory;
use SuperMetrics\Client\Model\Data\Response\DataFactory;
use SuperMetrics\Client\Model\Data\Response\ErrorFactory;
use SuperMetrics\Client\Model\Data\Response\MetaFactory;
use SuperMetrics\Client\Model\Data\ResponseFactory;
use SuperMetrics\Client\Model\Service\Client;
use SuperMetrics\Client\Model\Service\CurlRequest;
use SuperMetrics\Client\Model\Service\HttpClient;
use SuperMetrics\Client\Model\Service\RequestProvider;
use SuperMetrics\Client\Model\Service\ResponseParser;
use SuperMetrics\Client\Model\Service\ResponseValidator;
use SuperMetrics\PostAnalyzer\Model\Data\PostCollection;
use SuperMetrics\PostAnalyzer\Model\Service\DateHelper;
use SuperMetrics\PostAnalyzer\Model\Service\PostStatCollector\CharacterLengthByPostIdPerMonth;
use SuperMetrics\PostAnalyzer\Model\Service\PostStatCollector\PostsPerUserPerMonth;
use SuperMetrics\PostAnalyzer\Model\Service\PostStatCollector\TotalPostsByWeek;
use SuperMetrics\PostAnalyzer\Model\Service\PostStatCollectorPool;
use SuperMetrics\PostAnalyzer\Model\Service\PostStatResultParser;

$dotEnvReader = new DotEnvReader();
$configuration = new Configuration($dotEnvReader);
$requestFactory = new RequestFactory();
$responseDataFactory = new DataFactory();
$responseErrorFactory = new ErrorFactory();
$responseMetaFactory = new MetaFactory();
$responseFactory = new ResponseFactory($responseDataFactory, $responseErrorFactory, $responseMetaFactory);
$httpRequest = new CurlRequest();
$httpClient = new HttpClient($responseFactory, $httpRequest);
$requestProvider = new RequestProvider($configuration, $requestFactory);
$responseValidator = new ResponseValidator();
$postFactory = new PostFactory();
$responseParser = new ResponseParser($postFactory);
$client = new Client($httpClient, $requestProvider, $responseValidator, $responseParser);
$dateHelper = new DateHelper();
$statCollectors = [
    new CharacterLengthByPostIdPerMonth($dateHelper),
    new PostsPerUserPerMonth($dateHelper),
    new TotalPostsByWeek($dateHelper),
];
$postStatCollectorPool = new PostStatCollectorPool($statCollectors);
$postCollection = new PostCollection($postStatCollectorPool);
$postStatResultParser = new PostStatResultParser();
