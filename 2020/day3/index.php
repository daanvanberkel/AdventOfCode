<?php

declare(strict_types=1);

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);

$slopes = [
    [1, 1],
    [3, 1],
    [5, 1],
    [7, 1],
    [1, 2],
];
$results = [];

foreach($slopes as $slope) {
    $trees = 0;
    $x = 0;
    for ($y = 0; $y < count($lines); $y += $slope[1]) {
        $line = str_split($lines[$y]);
        $count = count($line);

        if ($count <= 1) {
            continue;
        }

        if ($x >= $count) {
            $x -= $count;
        }

        if ($line[$x] === '#') {
            $trees++;
        }

        $x += $slope[0];
    }

    echo sprintf("Result: %s\n", $trees);
    $results[] = $trees;
}

$result = 1;
foreach($results as $r) {
    $result *= $r;
}

echo sprintf("Result: %s\n", $result);
