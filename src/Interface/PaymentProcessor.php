<?php

namespace App\Interface;

use App\DTO\PaymentRequestDTO;

interface PaymentProcessor
{
    public function initiatePayment(PaymentRequestDTO $paymentRequestDTO);
}
