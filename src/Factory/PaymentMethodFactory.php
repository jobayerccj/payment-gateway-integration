<?php

namespace App\Factory;

use App\Interface\PaymentMethod;
use App\PaymentMethod\AciPayment;
use App\PaymentMethod\Shift4Payment;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentMethodFactory
{
    public static function getPaymentMethod(string $paymentType): ?PaymentMethod
    {
        switch ($paymentType) {
            case 'shift4':
                return new Shift4Payment();
            case 'aci':
                return new AciPayment();
            default:
                throw new NotFoundHttpException("no payment method found");
        }
    }
}
