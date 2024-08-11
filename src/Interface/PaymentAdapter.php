<?php

namespace App\Interface;

use App\DTO\PaymentResponseDTO;

interface PaymentAdapter
{
    public function convertPaymentDetailsToDTO($initialData): ?PaymentResponseDTO;
}
