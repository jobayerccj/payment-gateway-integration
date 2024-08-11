<?php

namespace App\Service;

use App\DTO\PaymentRequestDTO;
use App\Factory\PaymentAdapterFactory;
use App\Factory\PaymentMethodFactory;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaymentService
{
    public function __construct(protected ValidatorInterface $validator)
    {
    }

    public function processPayment(string $paymentType, array $request)
    {
        // validate data
        // complete DTO definition & update response
        // try catch handling
        // use logger where needed
        // update params, use all the request params properly instead of hard coded data
        // command for payment processing
        $paymentRequestData = new PaymentRequestDTO();
        $paymentRequestData
            ->setAmount((float)$request['amount'] ?? null)
            ->setCurrency($request['currency'] ?? '')
        ;

        $errors = $this->validator->validate($paymentRequestData);

        dump($errors);exit;

        $paymentMethod = PaymentMethodFactory::getPaymentMethod($paymentType);
        $initialData = $paymentMethod->initiatePayment($paymentRequestData);
        //dump($initialData);exit;
        $paymentMethodAdapter = PaymentAdapterFactory::getPaymentAdapter($paymentType);
        $paymentDetails = $paymentMethodAdapter->convertPaymentDetailsToDTO($initialData);
        //dump($paymentDetails);
        return $paymentDetails;
    }
}
