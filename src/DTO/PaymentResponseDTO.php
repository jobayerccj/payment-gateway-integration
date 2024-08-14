<?php

namespace App\DTO;

use DateTime;

class PaymentResponseDTO
{
    private string $transactionId;
    private DateTime $dateOfCreating;
    private float $amount;
    private string $currency;
    private CardDTO $cardDetails;

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): self
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    public function getDateOfCreating(): DateTime
    {
        return $this->dateOfCreating;
    }

    public function setDateOfCreating(DateTime $dateOfCreating): self
    {
        $this->dateOfCreating = $dateOfCreating;

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

    public function getCardDetails(): CardDTO
    {
        return $this->cardDetails;
    }

    public function setCardDetails(CardDTO $cardDetails): self
    {
        $this->cardDetails = $cardDetails;

        return $this;
    }
}
