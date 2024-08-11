<?php

namespace App\Factory;

use App\Adapter\AciPaymentAdapter;
use App\Adapter\Shift4PaymentAdapter;
use App\Interface\PaymentAdapter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentAdapterFactory
{
    public static function getPaymentAdapter(string $paymentType): ?PaymentAdapter
    {
        switch ($paymentType) {
            case 'shift4':
                return new Shift4PaymentAdapter();
            case 'aci':
                return new AciPaymentAdapter();
            default:
                throw new NotFoundHttpException("no payment adapter found");
        }
    }
}
