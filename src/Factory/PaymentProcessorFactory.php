<?php

namespace App\Factory;

use App\Interface\PaymentProcessor;
use App\PaymentProcessor\AciPaymentGateway;
use App\PaymentProcessor\Shift4PaymentGateway;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentProcessorFactory
{
    public function getPaymentProcessor(string $paymentType): ?PaymentProcessor
    {
        return match ($paymentType) {
            'shift4' => new Shift4PaymentGateway(),
            'aci' => new AciPaymentGateway(),
            default => throw new NotFoundHttpException("Wrong payment type provided, only shift4 & aci are available now."),
        };
    }
}
