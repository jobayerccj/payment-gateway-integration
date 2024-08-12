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
    private string $cardNumber;

    #[Assert\NotBlank]
    private int $cardExpYear;

    #[Assert\NotBlank]
    private string $cardExpMonth;

    #[Assert\NotBlank]
    private string $cardCvv;

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
     * @return string
     */
    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    /**
     * @param string $cardNumber
     */
    public function setCardNumber(string $cardNumber): self
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
     * @return string
     */
    public function getCardExpMonth(): string
    {
        return $this->cardExpMonth;
    }

    /**
     * @param string $cardExpMonth
     */
    public function setCardExpMonth(string $cardExpMonth): self
    {
        $this->cardExpMonth = $cardExpMonth;

        return $this;
    }

    /**
     * @return string
     */
    public function getCardCvv(): string
    {
        return $this->cardCvv;
    }

    /**
     * @param string $cardCvv
     */
    public function setCardCvv(string $cardCvv): self
    {
        $this->cardCvv = $cardCvv;

        return $this;
    }
}
