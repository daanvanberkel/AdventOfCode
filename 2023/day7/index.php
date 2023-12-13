<?php

declare(strict_types=1);

require_once __DIR__ . '/Card.php';
require_once __DIR__ . '/Hand.php';

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);

$hands = [];
foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '') {
        continue;
    }

    $parts = explode(' ' , $line);
    $cards = array_map(static fn ($c) => new Card($c), str_split($parts[0]));
    $hands[] = new Hand($cards, (int) $parts[1]);
}

function compareHandByCardScores(Hand $a, Hand $b): int {
    for ($i = 0; $i < 5; $i++) {
        if ($a->getCard($i)->getScore() === $b->getCard($i)->getScore()) {
            continue;
        }

        return $a->getCard($i)->getScore() <=> $b->getCard($i)->getScore();
    }

    return 0;
}

// Order hands using the following order rules:
// 1. Five of a kind
// 2. Four of a kind
// 3. Full house
// 4. Three of a kind
// 5. Two pair
// 6. One pair
// 7. High card

usort($hands, function(Hand $a, Hand $b) {
    if ($a->isFiveOfAKind() && !$b->isFiveOfAKind()) {
        return 1;
    }

    if (!$a->isFiveOfAKind() && $b->isFiveOfAKind()) {
        return -1;
    }

    if ($a->isFiveOfAKind() && $b->isFiveOfAKind()) {
        return compareHandByCardScores($a, $b);
    }

    if ($a->isFourOfAKind() && !$b->isFourOfAKind()) {
        return 1;
    }

    if (!$a->isFourOfAKind() && $b->isFourOfAKind()) {
        return -1;
    }

    if ($a->isFourOfAKind() && $b->isFourOfAKind()) {
        return compareHandByCardScores($a, $b);
    }

    if ($a->isFullHouse() && !$b->isFullHouse()) {
        return 1;
    }

    if (!$a->isFullHouse() && $b->isFullHouse()) {
        return -1;
    }

    if ($a->isFullHouse() && $b->isFullHouse()) {
        return compareHandByCardScores($a, $b);
    }

    if ($a->isThreeOfAKind() && !$b->isThreeOfAKind()) {
        return 1;
    }

    if (!$a->isThreeOfAKind() && $b->isThreeOfAKind()) {
        return -1;
    }

    if ($a->isThreeOfAKind() && $b->isThreeOfAKind()) {
        return compareHandByCardScores($a, $b);
    }

    if ($a->isTwoPair() && !$b->isTwoPair()) {
        return 1;
    }

    if (!$a->isTwoPair() && $b->isTwoPair()) {
        return -1;
    }

    if ($a->isTwoPair() && $b->isTwoPair()) {
        return compareHandByCardScores($a, $b);
    }

    if ($a->isOnePair() && !$b->isOnePair()) {
        return 1;
    }

    if (!$a->isOnePair() && $b->isOnePair()) {
        return -1;
    }

    if ($a->isOnePair() && $b->isOnePair()) {
        return compareHandByCardScores($a, $b);
    }

    if ($a->isHighCard() && !$b->isHighCard()) {
        return 1;
    }

    if (!$a->isHighCard() && $b->isHighCard()) {
        return -1;
    }

    if ($a->isHighCard() && $b->isHighCard()) {
        return compareHandByCardScores($a, $b);
    }

    return 0;
});

//foreach ($hands as $i => $hand) {
//    file_put_contents(
//        sprintf('%s/output.txt', __DIR__),
//        sprintf("%s\n", implode('', array_map(static fn (Card $c) => $c->getCard(), $hand->getCards()))),
//        FILE_APPEND
//    );
//}

$result = 0;
foreach ($hands as $i => $hand) {
    $result += ($i + 1) * $hand->getBid();
}

echo sprintf("Result: %s\n", $result);
