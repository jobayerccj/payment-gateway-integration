<?php

namespace App\Interface;

use App\DTO\PaymentRequestDTO;

interface PaymentProcessor
{
    public const SHIFT4_PAYMENT_GATEWAY = 'shift4';
    public const ACI_PAYMENT_GATEWAY = 'aci';
    public function initiatePayment(PaymentRequestDTO $paymentRequestDTO);
}
