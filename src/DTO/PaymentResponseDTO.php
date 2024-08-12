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

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     */
    public function setTransactionId(string $transactionId): self
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateOfCreating(): DateTime
    {
        return $this->dateOfCreating;
    }

    /**
     * @param DateTime $dateOfCreating
     */
    public function setDateOfCreating(DateTime $dateOfCreating): self
    {
        $this->dateOfCreating = $dateOfCreating;

        return $this;
    }

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
     * @return CardDTO
     */
    public function getCardDetails(): CardDTO
    {
        return $this->cardDetails;
    }

    /**
     * @param CardDTO $cardDetails
     */
    public function setCardDetails(CardDTO $cardDetails): self
    {
        $this->cardDetails = $cardDetails;

        return $this;
    }
}
