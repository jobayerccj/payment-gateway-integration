<?php

namespace App\Controller\PaymentMethod;

use App\DTO\PaymentRequestDTO;
use App\Interface\PaymentMethod;
use Shift4\Exception\Shift4Exception;
use Shift4\Request\ChargeRequest;
use Shift4\Shift4Gateway;

class Shift4Payment implements PaymentMethod
{
    public function initiatePayment(PaymentRequestDTO $paymentRequestDTO)
    {
        $gateway = new Shift4Gateway('pr_test_tXHm9qV9qV9bjIRHcQr9PLPa');

        try {
            $chargeRequest = new ChargeRequest();
            $chargeRequest
                ->amount($paymentRequestDTO->getAmount())
                ->currency($paymentRequestDTO->getCurrency())
                ->card([
                        'number' => '4242424242424242',
                        'expMonth' => 11,
                        'expYear' => 2026
                    ]
                );

            return $gateway->createCharge($chargeRequest);
        } catch (Shift4Exception $e) {
            throw new Shift4Exception();
        }
    }
}
