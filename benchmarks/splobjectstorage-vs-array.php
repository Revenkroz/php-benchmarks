<?php declare(strict_types=1);

function convertToBytes($size): string
{
    $unit = ['b','kb','mb','gb','tb','pb'];
    return @\round($size / \pow(1024, ($i = \floor(\log($size, 1024)))), 2) . ' ' . $unit[$i];
}

function testSplObjectStorage($objects): array
{
    $storage = new \SplObjectStorage();
    $memInit = \memory_get_usage();
    $start = \microtime(true);

    foreach ($objects as $object) {
        $storage->attach($object);
    }

    $timeToFill = \microtime(true) - $start;

    $start = \microtime(true);
    foreach ($objects as $object) {
        $storage->contains($object);
    }

    $timeToCheck = \microtime(true) - $start;
    $memoryUsage = \memory_get_usage() - $memInit;

    unset($storage);

    return [
        'timeToFill' => $timeToFill,
        'timeToCheck' => $timeToCheck,
        'memoryUsage' => $memoryUsage,
    ];
}

function testArray($objects): array
{
    $memInit = \memory_get_usage();
    $start = \microtime(true);
    $storage = [];

    foreach ($objects as $object) {
        $storage[\spl_object_hash($object)] = $object;
    }

    $timeToFill = \microtime(true) - $start;

    $start = \microtime(true);
    foreach ($storage as $element) {
        isset($arrays[\spl_object_hash($element)]);
    }

    $timeToCheck = \microtime(true) - $start;
    $memoryUsage = \memory_get_usage() - $memInit;

    unset($storage);

    return [
        'timeToFill' => $timeToFill,
        'timeToCheck' => $timeToCheck,
        'memoryUsage' => $memoryUsage,
    ];
}

$numOfTestObjects = 100000;
$objects = [];
for ($i = 0; $i < $numOfTestObjects; $i++) {
    $objects[] = new \stdClass();
}

$storages = ['array', 'SplObjectStorage'];
\shuffle($storages);

$results = [];
foreach ($storages as $storage) {
    $functionName = \sprintf('test%s', \ucfirst($storage));
    $results[$storage] = $functionName($objects);
}

foreach ($results as $storage => $result) {
    echo \sprintf("%s test\nTime to fill: %0.10f\nTime to check: %0.10f\nMemory usage: %s\n\n", \ucfirst($storage), $result['timeToFill'], $result['timeToCheck'], convertToBytes($result['memoryUsage']));
}
