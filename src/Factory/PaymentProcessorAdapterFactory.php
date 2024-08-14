<?php

namespace App\Factory;

use App\Adapter\AciPaymentAdapter;
use App\Adapter\Shift4PaymentAdapter;
use App\Interface\PaymentProcessorAdapter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentProcessorAdapterFactory
{
    public static function getPaymentAdapter(string $paymentType): ?PaymentProcessorAdapter
    {
        return match ($paymentType) {
            'shift4' => new Shift4PaymentAdapter(),
            'aci' => new AciPaymentAdapter(),
            default => throw new NotFoundHttpException("no payment adapter found"),
        };
    }
}
