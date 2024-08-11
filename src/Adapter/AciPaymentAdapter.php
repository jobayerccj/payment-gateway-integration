<?php

namespace App\Adapter;
;
use App\DTO\PaymentResponseDTO;
use App\Interface\PaymentAdapter;

class AciPaymentAdapter implements PaymentAdapter
{
    public function convertPaymentDetailsToDTO($initialData): ?PaymentResponseDTO
    {
        $paymentResponseDTO = new PaymentResponseDTO();
        $paymentResponseDTO
            ->setAmount((float)$initialData->amount)
            ->setCurrency($initialData->currency)
        ;

        return $paymentResponseDTO;
    }
}
