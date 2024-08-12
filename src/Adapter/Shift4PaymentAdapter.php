<?php

namespace App\Adapter;

use App\DTO\CardDTO;
use App\DTO\PaymentResponseDTO;
use App\Interface\PaymentAdapter;
use DateTime;

class Shift4PaymentAdapter implements PaymentAdapter
{
    public function convertPaymentDetailsToDTO($initialData): ?PaymentResponseDTO
    {
        $paymentResponseDTO = new PaymentResponseDTO();
        $creatingDate = new DateTime();
        $card = $initialData->getCard();
        $cardDetails = new CardDTO($card->getFirst6(), $card->getExpYear(), $card->getExpMonth());

        $paymentResponseDTO
            ->setTransactionId($initialData->getId())
            ->setDateOfCreating($creatingDate->setTimestamp($initialData->getCreated()))
            ->setAmount((float)$initialData->getAmount())
            ->setCurrency($initialData->getCurrency())
            ->setCardDetails($cardDetails)
            ;
        return $paymentResponseDTO;
    }
}
