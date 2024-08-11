<?php

namespace App\Interface;

use App\DTO\PaymentRequestDTO;

interface PaymentMethod
{
    public const PAYMENT_METHOD_SHIFT4 = 'shift4';
    public const PAYMENT_METHOD_ACI = 'aci';
    public function initiatePayment(PaymentRequestDTO $paymentRequestDTO);
}
