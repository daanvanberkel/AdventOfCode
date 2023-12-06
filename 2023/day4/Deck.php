<?php

declare(strict_types=1);

class Deck
{
    /**
     * @var array<Card>
     */
    private array $cards = [];

    /**
     * @var array<Card>
     */
    private array $cardsToProcess = [];

    public function addCard(Card $card): void
    {
        $this->cards[$card->getId()] = $card;
    }

    public function getResult(): int
    {
        $this->cardsToProcess = array_values($this->cards);

        for($i = 0; $i < count($this->cardsToProcess); $i++) {
            $card = $this->cardsToProcess[$i];
            echo sprintf("Card %s\n", $card->getId());

            $winningCount = $card->getScore();
            if ($winningCount === 0) {
                continue;
            }

            for ($j = 1; $j <= $winningCount; $j++) {
                if (!array_key_exists($card->getId() + $j, $this->cards)) {
                    continue;
                }

                $this->cardsToProcess[] = $this->cards[$card->getId() + $j];
            }
        }

        return count($this->cardsToProcess);
    }
}