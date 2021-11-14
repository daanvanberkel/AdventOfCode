<?php

declare(strict_types=1);

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);

foreach($lines as $x) {
    $x = (int) $x;

    foreach($lines as $y) {
        $y = (int) $y;

        foreach($lines as $z) {
            $z = (int) $z;

            if ($x + $y + $z === 2020) {
                echo sprintf("Result: %s\n", ($x * $y * $z));
                exit;
            }
        }
    }
}
