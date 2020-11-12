<?php

declare(strict_types=1);

/**
 *
 * Copyright (c) Jaakko Toivanen (https://github.com/toijaakko)
 *
 * See LICENSE.txt for license details
 *
 */

use SuperMetrics\Client\Api\Service\ClientInterface;
use SuperMetrics\PostAnalyzer\Api\Data\PostCollectionInterface;
use SuperMetrics\PostAnalyzer\Api\Service\PostStatResultParserInterface;

/** @var ClientInterface|null $client */
$client = null;
/** @var PostCollectionInterface|null $postCollection */
$postCollection = null;
/** @var PostStatResultParserInterface|null $postStatResultParser */
$postStatResultParser = null;

require __DIR__ . '/autoload.php';

foreach (\range(1, 10) as $page) {
    $posts = $client->getPosts($page);

    foreach ($posts as $post) {
        $postCollection->addPost($post);
    }
}

$result = $postStatResultParser->getResult($postCollection);

$resultJson = \json_encode($result, JSON_PRETTY_PRINT);

$f = \fopen('result.json', 'w');
\fwrite($f, $resultJson);
\fclose($f);

echo $resultJson . PHP_EOL;
