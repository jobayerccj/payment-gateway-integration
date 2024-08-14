<?php

namespace App\PaymentProcessor;

use App\DTO\PaymentRequestDTO;
use App\Interface\PaymentProcessor;
use Shift4\Exception\Shift4Exception;
use Shift4\Request\ChargeRequest;
use Shift4\Response\Charge;
use Shift4\Shift4Gateway;

class Shift4PaymentGateway implements PaymentProcessor
{
    public function initiatePayment(PaymentRequestDTO $paymentRequestDTO): Charge
    {
        $gateway = new Shift4Gateway('pr_test_tXHm9qV9qV9bjIRHcQr9PLPa');

        try {
            $chargeRequest = new ChargeRequest();
            $chargeRequest
                ->amount($paymentRequestDTO->getAmount())
                ->currency($paymentRequestDTO->getCurrency())
                ->card([
                    'number' => $paymentRequestDTO->getCardNumber(),
                    'expMonth' => $paymentRequestDTO->getCardExpMonth(),
                    'expYear' => $paymentRequestDTO->getCardExpYear(),
                ]);

            return $gateway->createCharge($chargeRequest);
        } catch (Shift4Exception $exc) {
            throw new Shift4Exception();
        }
    }
}
