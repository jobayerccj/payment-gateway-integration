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
        switch ($paymentType) {
            case 'shift4':
                return new Shift4PaymentGateway();
            case 'aci':
                return new AciPaymentGateway();
            default:
                throw new NotFoundHttpException("Wrong payment type provided, only shift4 & aci are available now.");
        }
    }
}
