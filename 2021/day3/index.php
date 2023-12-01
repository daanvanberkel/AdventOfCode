<?php

declare(strict_types=1);

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);

$columns = [];

foreach ($lines as $line) {
    $line = trim($line);
    if (strlen($line) === 0) {
        continue;
    }

    $bits = str_split($line);

    foreach ($bits as $index => $bit) {
        if (!array_key_exists($index, $columns)) {
            $columns[$index] = [];
        }

        $columns[$index][] = $bit;
    }
}

$gamma = '';
$epsilon = '';

foreach ($columns as $column) {
    $on = array_filter($column, static fn (string $bit) => $bit === '1');
    $off = array_filter($column, static fn (string $bit) => $bit === '0');

    if (count($on) > count($off)) {
        $gamma .= '1';
        $epsilon .= '0';
    } else {
        $gamma .= '0';
        $epsilon .= '1';
    }
}

$gamma = bindec($gamma);
$epsilon = bindec($epsilon);

echo sprintf("Result: %s\n", ($gamma * $epsilon));
