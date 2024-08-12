<?php

namespace App\Adapter;
;

use App\DTO\CardDTO;
use App\DTO\PaymentResponseDTO;
use App\Interface\PaymentAdapter;
use DateTime;

class AciPaymentAdapter implements PaymentAdapter
{
    public function convertPaymentDetailsToDTO($initialData): ?PaymentResponseDTO
    {
        $paymentResponseDTO = new PaymentResponseDTO();
        $creatingDate = new DateTime($initialData->timestamp);
        $cardDetails = new CardDTO($initialData->card->bin, $initialData->card->expiryYear, $initialData->card->expiryMonth);
        $paymentResponseDTO
            ->setTransactionId($initialData->id)
            ->setDateOfCreating($creatingDate)
            ->setAmount((float)$initialData->amount)
            ->setCurrency($initialData->currency)
            ->setCardDetails($cardDetails)
        ;

        return $paymentResponseDTO;
    }
}
