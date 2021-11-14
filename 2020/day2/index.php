<?php

declare(strict_types=1);

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);

$valid = 0;
foreach($lines as $line) {
    preg_match('/([0-9]+)-([0-9]+) ([a-z]): (.*)/', $line, $matches);

    if (count($matches) < 5) {
        continue;
    }

    $pos1 = (int) $matches[1];
    $pos2 = (int) $matches[2];
    $letter = $matches[3];
    $password = $matches[4];
    $foundMatched = 0;

    $characters = str_split($password);
    if (
        ($characters[$pos1 - 1] === $letter && $characters[$pos2 - 1] !== $letter) ||
        ($characters[$pos1 - 1] !== $letter && $characters[$pos2 - 1] === $letter)
    ) {
        $valid++;
    }
}

echo sprintf("Result: %s\n", $valid);
