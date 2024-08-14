<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class PaymentRequestDTO
{
    #[Assert\NotBlank]
    private string $paymentType;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(0, message: 'amount is required & should be greater than 0.',)]
    private float $amount;

    #[Assert\NotBlank]
    private string $currency;

    #[Assert\NotBlank]
    private string $cardNumber;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(2023, message: 'cardExpYear is required & should be greater than 2024.',)]
    private int $cardExpYear;

    #[Assert\NotBlank]
    private string $cardExpMonth;

    #[Assert\NotBlank]
    private string $cardCvv;

    public function getPaymentType(): string
    {
        return $this->paymentType;
    }

    public function setPaymentType(string $paymentType): self
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    public function setCardNumber(string $cardNumber): self
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    public function getCardExpYear(): int
    {
        return $this->cardExpYear;
    }

    public function setCardExpYear(int $cardExpYear): self
    {
        $this->cardExpYear = $cardExpYear;

        return $this;
    }

    public function getCardExpMonth(): string
    {
        return $this->cardExpMonth;
    }

    public function setCardExpMonth(string $cardExpMonth): self
    {
        $this->cardExpMonth = $cardExpMonth;

        return $this;
    }

    public function getCardCvv(): string
    {
        return $this->cardCvv;
    }

    public function setCardCvv(string $cardCvv): self
    {
        $this->cardCvv = $cardCvv;

        return $this;
    }
}
