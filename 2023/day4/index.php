<?php

declare(strict_types=1);

require_once __DIR__ . '/Card.php';
require_once __DIR__ . '/Deck.php';

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);

function parseNumbers(string $numbers): array {
    $numbers = array_map(static fn ($c) => trim($c), explode(' ', trim($numbers)));
    return array_filter($numbers, static fn ($c) => $c !== '');
}

$deck = new Deck();
foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '') {
        continue;
    }

    $parts = explode(':', $line);
    $cardId = (int) trim(str_replace('Card ', '', $parts[0]));
    $numbers = explode('|', trim($parts[1]));
    $winningNumbers = parseNumbers($numbers[0]);
    $numbers = parseNumbers($numbers[1]);

    $card = new Card($cardId, $winningNumbers, $numbers);
    $deck->addCard($card);
}

echo sprintf("Result: %s\n", $deck->getResult());
