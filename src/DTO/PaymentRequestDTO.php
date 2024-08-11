<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class PaymentRequestDTO
{
    #[Assert\NotBlank]
    private float $amount;

    #[Assert\NotBlank]
    private string $currency;

    #[Assert\NotBlank]
    private int $cardNumber;

    #[Assert\NotBlank]
    private int $cardExpYear;

    #[Assert\NotBlank]
    private int $cardExpMonth;

    #[Assert\NotBlank]
    private int $cardCvv;

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return int
     */
    public function getCardNumber(): int
    {
        return $this->cardNumber;
    }

    /**
     * @param int $cardNumber
     */
    public function setCardNumber(int $cardNumber): self
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getCardExpYear(): int
    {
        return $this->cardExpYear;
    }

    /**
     * @param int $cardExpYear
     */
    public function setCardExpYear(int $cardExpYear): self
    {
        $this->cardExpYear = $cardExpYear;

        return $this;
    }

    /**
     * @return int
     */
    public function getCardExpMonth(): int
    {
        return $this->cardExpMonth;
    }

    /**
     * @param int $cardExpMonth
     */
    public function setCardExpMonth(int $cardExpMonth): self
    {
        $this->cardExpMonth = $cardExpMonth;

        return $this;
    }

    /**
     * @return int
     */
    public function getCardCvv(): int
    {
        return $this->cardCvv;
    }

    /**
     * @param int $cardCvv
     */
    public function setCardCvv(int $cardCvv): self
    {
        $this->cardCvv = $cardCvv;

        return $this;
    }
}
