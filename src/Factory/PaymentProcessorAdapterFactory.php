<?php

namespace App\Factory;

use App\Adapter\AciPaymentAdapter;
use App\Adapter\Shift4PaymentAdapter;
use App\Interface\PaymentProcessor;
use App\Interface\PaymentProcessorAdapter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentProcessorAdapterFactory
{
    public static function getPaymentAdapter(string $paymentType): ?PaymentProcessorAdapter
    {
        return match ($paymentType) {
            PaymentProcessor::SHIFT4_PAYMENT_GATEWAY => new Shift4PaymentAdapter(),
            PaymentProcessor::ACI_PAYMENT_GATEWAY => new AciPaymentAdapter(),
            default => throw new NotFoundHttpException('no payment adapter found'),
        };
    }
}
