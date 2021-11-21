<?php

declare(strict_types=1);

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);
$groups = [];
$group = [];

foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '') {
        $groups[] = $group;
        $group = [];
        continue;
    }

    $group[] = str_split($line);
}

$result = 0;

foreach($groups as $group) {
    $same = array_intersect(...$group);
    $result += count($same);
}

echo sprintf("Result: %s\n", $result);
