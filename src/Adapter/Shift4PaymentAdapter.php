<?php

namespace App\Adapter;

use App\DTO\PaymentResponseDTO;
use App\Interface\PaymentAdapter;

class Shift4PaymentAdapter implements PaymentAdapter
{
    public function convertPaymentDetailsToDTO($initialData): ?PaymentResponseDTO
    {
        $paymentResponseDTO = new PaymentResponseDTO();
        $paymentResponseDTO
            ->setAmount((float)$initialData->getAmount())
            ->setCurrency($initialData->getCurrency())
            ;
        return $paymentResponseDTO;
    }
}
