<?php

declare(strict_types=1);

require_once __DIR__ . '/Range.php';
require_once __DIR__ . '/Map.php';

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);

$seeds = array_map(static fn ($i) => (int) $i, explode(' ', trim(str_replace('seeds:', '', array_shift($lines)))));
$seedsToSoilMap = new Map();
$soilToFertilizerMap = new Map();
$fertilizerToWaterMap = new Map();
$waterToLightMap = new Map();
$lightToTemperatureMap = new Map();
$temperatureToHumidityMap = new Map();
$humidityToLocationMap = new Map();

$currentMap = &$seedsToSoilMap;

foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '') {
        continue;
    }

    if (str_starts_with($line, 'seed-to-soil map:')) {
        $currentMap = &$seedsToSoilMap;
        continue;
    }

    if (str_starts_with($line, 'soil-to-fertilizer map:')) {
        $currentMap = &$soilToFertilizerMap;
        continue;
    }

    if (str_starts_with($line, 'fertilizer-to-water map:')) {
        $currentMap = &$fertilizerToWaterMap;
        continue;
    }

    if (str_starts_with($line, 'water-to-light map:')) {
        $currentMap = &$waterToLightMap;
        continue;
    }

    if (str_starts_with($line, 'light-to-temperature map:')) {
        $currentMap = &$lightToTemperatureMap;
        continue;
    }

    if (str_starts_with($line, 'temperature-to-humidity map:')) {
        $currentMap = &$temperatureToHumidityMap;
        continue;
    }

    if (str_starts_with($line, 'humidity-to-location map:')) {
        $currentMap = &$humidityToLocationMap;
        continue;
    }

    $parts = explode(' ', $line);
    $currentMap->addRange((int) $parts[0], (int) $parts[1], (int) $parts[2]);
}

$result = null;
for ($i = 0; $i < count($seeds); $i += 2) {
    $startSeed = $seeds[$i];
    $length = $seeds[$i + 1];

    for ($j = $startSeed; $j < $startSeed + $length; $j++) {
        $seed = $startSeed + $j;

        $soil = $seedsToSoilMap->getDestination($seed);
        $fertilizer = $soilToFertilizerMap->getDestination($soil);
        $water = $fertilizerToWaterMap->getDestination($fertilizer);
        $light = $waterToLightMap->getDestination($water);
        $temperature = $lightToTemperatureMap->getDestination($light);
        $humidity = $temperatureToHumidityMap->getDestination($temperature);
        $location = $humidityToLocationMap->getDestination($humidity);

        if ($result === null || $location < $result) {
            $result = $location;
        }
    }
}

echo sprintf("Result: %s\n", $result);
