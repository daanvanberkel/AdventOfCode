<?php

declare(strict_types=1);

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);

$horizontal = 0;
$depth = 0;
$aim = 0;

foreach ($lines as $line) {
    $line = trim($line);
    if (strlen($line) === 0) {
        continue;
    }

    [$movement, $amount] = explode(' ', $line);
    $amount = (int) $amount;

    switch ($movement) {
        case 'forward':
            $horizontal += $amount;
            $depth += ($aim * $amount);
            break;

        case 'up':
            $aim -= $amount;
            break;

        case 'down':
            $aim += $amount;
            break;
    }
}

echo sprintf("Result: %s\n", ($horizontal * $depth));
