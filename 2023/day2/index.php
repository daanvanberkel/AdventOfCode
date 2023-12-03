<?php

declare(strict_types=1);

const TOTAL_REDS = 12;
const TOTAL_GREEN = 13;
const TOTAL_BLUES = 14;

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);

$results = [];

foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '') {
        continue;
    }

    $gameData = explode(':', $line);
    $gameId = (int) str_replace('Game ', '', $gameData[0]);

    $games = explode(';', $gameData[1]);
    $totals = [
        'red' => 0,
        'green' => 0,
        'blue' => 0,
    ];

    foreach ($games as $game) {
        $rounds = explode(',', $game);

        foreach ($rounds as $round) {
            $round = trim($round);
            $parts = explode(' ', $round);

            $color = $parts[1];
            $amount = (int) $parts[0];

            if ($totals[$color] > $amount) {
                continue;
            }

            $totals[$color] = $amount;
        }
    }

    $results[] = $totals['red'] * $totals['green'] * $totals['blue'];
}

echo sprintf("Result: %s\n", array_sum($results));
