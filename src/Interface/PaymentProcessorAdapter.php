<?php

namespace App\Interface;

use App\DTO\PaymentResponseDTO;

interface PaymentProcessorAdapter
{
    public function convertPaymentDetailsToDTO($initialData): ?PaymentResponseDTO;
}
