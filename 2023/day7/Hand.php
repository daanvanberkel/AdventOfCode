<?php

declare(strict_types=1);

readonly class Hand
{
    /**
     * @param array<Card> $cards
     */
    public function __construct(
        private array $cards,
        private int $bid,
    ) {
    }

    public function getCard(int $index): Card
    {
        if (count($this->cards) < $index + 1) {
            throw new RuntimeException('Cannot get card for given index');
        }

        return $this->cards[$index];
    }

    /**
     * @return array<Card>
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    public function getBid(): int
    {
        return $this->bid;
    }

    public function isFiveOfAKind(): bool
    {
        foreach ($this->cards as $card) {
            return $this->getCommonCardCount($card) === 5 || $this->getCommonCardCount($card) + $this->getJokers() >= 5;
        }

        return false;
    }

    public function isFourOfAKind(): bool
    {
        foreach ($this->cards as $card) {
            if ($this->getCommonCardCount($card) === 4 || $this->getCommonCardCount($card) + $this->getJokers() >= 4) {
                return true;
            }
        }

        return false;
    }

    public function isFullHouse(): bool
    {
        $threeOfAKind = null;
        foreach ($this->cards as $card) {
            if ($this->getCommonCardCount($card) === 3) {
                $threeOfAKind = $card->getCard();
                break;
            }
        }

        if ($threeOfAKind === null) {
            return false;
        }

        $twoOfAKind = null;
        foreach ($this->cards as $card) {
            if ($card->getCard() === $threeOfAKind) {
                continue;
            }

            if ($this->getCommonCardCount($card) === 2) {
                $twoOfAKind = $card->getCard();
                break;
            }
        }

        return $twoOfAKind !== null;
    }

    public function isThreeOfAKind(): bool
    {
        $threeOfAKind = null;
        foreach ($this->cards as $card) {
            if ($this->getCommonCardCount($card) === 3) {
                $threeOfAKind = $card->getCard();
                break;
            }
        }

        return $threeOfAKind !== null;
    }

    public function isTwoPair(): bool
    {
        $firstPair = null;
        foreach ($this->cards as $card) {
            if ($this->getCommonCardCount($card) === 2) {
                $firstPair = $card->getCard();
                break;
            }
        }

        if ($firstPair === null) {
            return false;
        }

        $secondPair = null;
        foreach ($this->cards as $card) {
            if ($card->getCard() === $firstPair) {
                continue;
            }

            if ($this->getCommonCardCount($card) === 2) {
                $secondPair = $card->getCard();
                break;
            }
        }

        if ($secondPair === null) {
            return false;
        }

        foreach ($this->cards as $card) {
            if ($card->getCard() === $firstPair || $card->getCard() === $secondPair) {
                continue;
            }

            if ($this->getCommonCardCount($card) === 1) {
                return true;
            }
        }

        return false;
    }

    public function isOnePair(): bool
    {
        $pair = null;
        foreach ($this->cards as $card) {
            if ($this->getCommonCardCount($card) === 2) {
                $pair = $card->getCard();
                break;
            }
        }

        return $pair !== null;
    }

    public function isHighCard(): bool
    {
        foreach ($this->cards as $card) {
            if ($this->getCommonCardCount($card) !== 1) {
                return false;
            }
        }

        return true;
    }

    private function getCommonCardCount(Card $card): int
    {
        $commonCards = array_filter($this->cards, static fn (Card $c) => $c->getCard() === $card->getCard());
        return count($commonCards);
    }

    private function getJokers(): int
    {
        $jokers = array_filter($this->cards, static fn (Card $c) => $c->getCard() === 'J');
        return count($jokers);
    }
}
