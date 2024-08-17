<?php

namespace App\Factory;

use App\Interface\PaymentProcessorInterface;
use App\PaymentProcessor\AciPaymentGateway;
use App\PaymentProcessor\Shift4PaymentGateway;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentProcessorFactory
{
    public function getPaymentProcessor(string $paymentType): ?PaymentProcessorInterface
    {
        return match ($paymentType) {
            PaymentProcessorInterface::SHIFT4_PAYMENT_GATEWAY => new Shift4PaymentGateway(),
            PaymentProcessorInterface::ACI_PAYMENT_GATEWAY => new AciPaymentGateway(),
            default => throw new NotFoundHttpException('Wrong payment type provided, only shift4 & aci are available now.'),
        };
    }
}
