<?php

declare(strict_types=1);

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);

function findDigit(string $haystack, int $start): ?int
{
    $digitWords = ['one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5, 'six' => 6, 'seven' => 7, 'eight' => 8, 'nine' => 9];
    $word = '';
    $characters = str_split($haystack);

    for ($i = $start; $i < count($characters); $i++) {
        $word .= $characters[$i];

        if (array_key_exists($word, $digitWords)) {
            echo sprintf("\tFound word %s in %s\n", $word, $haystack);
            return $digitWords[$word];
        }

        if (is_numeric($characters[$i]) && strlen($word) === 1) {
            return (int) $characters[$i];
        }
    }

    return null;
}

$numbers = [];
foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '') {
        continue;
    }

    echo sprintf("%s\n", $line);

    $firstNumber = null;
    $lastNumber = null;

    for ($i = 0; $i < strlen($line); $i++) {
        $result = findDigit($line, $i);
        if ($result !== null) {
            $firstNumber = $result;
            break;
        }
    }

    for ($i = strlen($line); $i >= 0; $i--) {
        $result = findDigit($line, $i);
        if ($result !== null) {
            $lastNumber = $result;
            break;
        }
    }

    echo sprintf("\tFirst: %s, Last %s\n", $firstNumber, $lastNumber);

    $numbers[] = (int) sprintf('%s%s', $firstNumber, $lastNumber);
}

echo sprintf("Output: %s\n", array_sum($numbers));
