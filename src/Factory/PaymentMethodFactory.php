<?php

namespace App\Factory;

use App\Controller\PaymentMethod\AciPayment;
use App\Controller\PaymentMethod\Shift4Payment;
use App\Interface\PaymentMethod;
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
