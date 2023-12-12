<?php

declare(strict_types=1);

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);

function parseNumbers(string $prefix, string $line): array
{
    $line = str_replace($prefix, '', $line);
    $parts = explode(' ', $line);
    $parts = array_filter($parts, static fn ($part) => $part !== '');
    $value = array_reduce($parts, static fn ($a, $b) => $a . $b, '');
    return [(int) $value];
}

$times = parseNumbers('Time:', $lines[0]);
$distances = parseNumbers('Distance:', $lines[1]);

$result = null;
foreach ($times as $i => $time) {
    $distance = $distances[$i];

//    echo sprintf("Time: %s, Record distance: %s\n", $time, $distance);

    $possibilities = 0;
    for ($j = 0; $j < $time; $j++) {
        $passedTime = $j;
        $speed = $passedTime;
        $remainingTime = $time - $j;
        $traveledDistance = $speed * ($time - $j);
//        echo sprintf("\tSpeed: %s, Traveled: %s, Remaining time: %s\n", $speed, $traveledDistance, $remainingTime);

        if ($traveledDistance > $distance) {
//            echo "\t\tYes\n";
            $possibilities++;
        } else {
//            echo "\t\tNo\n";
        }
    }

    if ($result === null) {
        $result = $possibilities;
    } else {
        $result *= $possibilities;
    }
}

echo sprintf("Result: %s\n", $result);
