<?php

namespace App\Interface;

use App\DTO\PaymentRequestDTO;
use App\DTO\PaymentResponseDTO;

interface PaymentProcessorInterface
{
    public const SHIFT4_PAYMENT_GATEWAY = 'shift4';
    public const ACI_PAYMENT_GATEWAY = 'aci';

    public function getPaymentDetails(PaymentRequestDTO $paymentRequestDTO): ?PaymentResponseDTO;
    public function initiatePayment(PaymentRequestDTO $paymentRequestDTO);
    public function convertPaymentDetailsToDTO($initialData): ?PaymentResponseDTO;
}
