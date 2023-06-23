#!/usr/bin/env php
<?php

declare(strict_types=1);

if (3 !== $argc) {
    echo PHP_EOL.'Usage: '.$argv[0].' <path/to/coverage.xml> <threshold>'.PHP_EOL.PHP_EOL;
    exit(-1);
}

$file = $argv[1];
$threshold = (float) $argv[2];

$coverage = simplexml_load_string(file_get_contents($file));
$ratio = (float) $coverage->project->directory->totals->lines['percent'];

printf('Line coverage: %s%%%s', $ratio, PHP_EOL);
printf('Threshold: %s%%%s', $threshold, PHP_EOL);

if ($ratio < $threshold) {
    exit(-1);
}
