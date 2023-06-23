#!/usr/bin/env php
<?php

declare(strict_types=1);

// Inspired by https://ocramius.github.io/blog/automated-code-coverage-check-for-github-pull-requests-with-travis/

require_once __DIR__.'/../vendor/autoload.php';

if (!is_countable($argv) || 2 !== count($argv)) {
    printf('%sUsage: %s [minimum-code-coverage-in-percent]%s%s', PHP_EOL, basename(__FILE__), PHP_EOL, PHP_EOL);
    exit(1);
}

$minimumCodeCoverageInPercent = (int) $argv[1];

$phpunitConfig = new SimpleXMLElement(file_get_contents(__DIR__.'/../phpunit.xml.dist'));
$cloverSourceFile = (string) $phpunitConfig->coverage->report->clover['outputFile'];
if ('' === $cloverSourceFile) {
    printf(
        '%sUnable to find Clover file in phpunit.xml.dist%s%s',
        PHP_EOL,
        PHP_EOL,
        PHP_EOL
    );
    exit(1);
}
if (!file_exists($cloverSourceFile) || !is_readable($cloverSourceFile)) {
    printf(
        '%sClover file is not found or not readable%s%s',
        PHP_EOL,
        PHP_EOL,
        PHP_EOL
    );
    exit(1);
}

$cloverXML = new SimpleXMLElement(file_get_contents($cloverSourceFile));
$coverageInPercent = (float) $cloverXML->project->directory->totals->lines['percent'];

if ($coverageInPercent < $minimumCodeCoverageInPercent) {
    printf(
        '%sCode coverage is %d%%, which is below the accepted %d%%.%s%s',
        PHP_EOL,
        $coverageInPercent,
        $minimumCodeCoverageInPercent,
        PHP_EOL,
        PHP_EOL
    );
    exit(1);
}

printf(
    '%sCode coverage is %d%% - OK!%s%s',
    PHP_EOL,
    $coverageInPercent,
    PHP_EOL,
    PHP_EOL
);
