<?php

namespace App\DTO;

class CardDTO
{
    public function __construct(
        private readonly string $cardBin,
        private readonly int $cardExpYear,
        private readonly string $cardExpMonth
    ) {
    }

    public function getCardBin(): string
    {
        return $this->cardBin;
    }

    public function getCardExpYear(): int
    {
        return $this->cardExpYear;
    }

    public function getCardExpMonth(): string
    {
        return $this->cardExpMonth;
    }
}
