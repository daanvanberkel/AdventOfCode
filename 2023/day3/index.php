<?php

declare(strict_types=1);

require_once __DIR__ . '/Map.php';

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);
$map = new Map($lines);

$result = 0;
foreach ($lines as $y => $line) {
    $line = trim($line);
    if ($line === '') {
        continue;
    }

    $characters = str_split($line);
    foreach ($characters as $x => $character) {
        if ($character === '.' || !preg_match('/\*/', $character)) {
            continue;
        }

        $numbers = [];
        $numbers[] = $map->getNumberAtPos($x - 1, $y - 1);
        $numbers[] = $map->getNumberAtPos($x - 1, $y);
        $numbers[] = $map->getNumberAtPos($x - 1, $y + 1);
        $numbers[] = $map->getNumberAtPos($x, $y - 1);
        $numbers[] = $map->getNumberAtPos($x, $y + 1);
        $numbers[] = $map->getNumberAtPos($x + 1, $y - 1);
        $numbers[] = $map->getNumberAtPos($x + 1, $y);
        $numbers[] = $map->getNumberAtPos($x + 1, $y + 1);
        $numbers = array_values(array_unique(array_filter($numbers, static fn ($n) => $n !== null)));

        if (count($numbers) !== 2) {
            continue;
        }

        $result += $numbers[0] * $numbers[1];
    }
}

echo sprintf("Result: %s\n", $result);
