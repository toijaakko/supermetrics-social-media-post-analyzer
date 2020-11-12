<?php

require_once '.php_cs.dist';

$finder = PhpCsFixer\Finder::create()
    ->in('.');

$config->setFinder($finder);

return $config;
