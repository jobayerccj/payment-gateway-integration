<?php

namespace App\DTO;

class CardDTO
{
    public function __construct(
        private string $cardBin,
        private int $cardExpYear,
        private string $cardExpMonth
    ){
    }

    /**
     * @return string
     */
    public function getCardBin(): string
    {
        return $this->cardBin;
    }

    /**
     * @return int
     */
    public function getCardExpYear(): int
    {
        return $this->cardExpYear;
    }

    /**
     * @return string
     */
    public function getCardExpMonth(): string
    {
        return $this->cardExpMonth;
    }
}
