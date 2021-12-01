<?php

declare(strict_types=1);

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);

$increments = 0;
$lastWindow = null;

for ($i = 0; $i < count($lines); $i++) {
    if ($i + 2 >= count($lines)) {
        break;
    }

    $window = ((int) $lines[$i]) + ((int) $lines[$i + 1]) + ((int) $lines[$i + 2]);

    if ($lastWindow === null) {
        $lastWindow = $window;
        continue;
    }

    if ($window > $lastWindow) {
        $increments++;
    }

    $lastWindow = $window;
}

echo sprintf("Result: %s\n", $increments);
