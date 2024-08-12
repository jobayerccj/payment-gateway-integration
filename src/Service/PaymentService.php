<?php

namespace App\Service;

use App\DTO\PaymentRequestDTO;
use App\DTO\PaymentResponseDTO;
use App\Factory\PaymentAdapterFactory;
use App\Factory\PaymentMethodFactory;

class PaymentService
{
    public function __construct(protected DataValidator $dataValidator)
    {
    }

    public function processPayment(string $paymentType, array $request)
    {
        // try catch handling
        // use logger where needed
        $paymentRequestData = new PaymentRequestDTO();
        $paymentRequestData
            ->setAmount((float)$request['amount'] ?? null)
            ->setCurrency($request['currency'] ?? '')
            ->setCardNumber($request['cardNumber'] ?? '')
            ->setCardExpYear($request['cardExpYear'] ?? null)
            ->setCardExpMonth($request['cardExpMonth'] ?? null)
            ->setCardCvv($request['cardCvv'] ?? null)
        ;

        $this->dataValidator->validateData($paymentRequestData);
        $paymentMethod = PaymentMethodFactory::getPaymentMethod($paymentType);
        $initialData = $paymentMethod->initiatePayment($paymentRequestData);
        //dump($initialData);
        //exit;
        $paymentMethodAdapter = PaymentAdapterFactory::getPaymentAdapter($paymentType);
        $paymentDetails = $paymentMethodAdapter->convertPaymentDetailsToDTO($initialData);
        //dump($paymentDetails);
        return $this->findPaymentResponse($paymentDetails);
    }

    private function findPaymentResponse(PaymentResponseDTO $paymentDetails): array
    {
        return [
            'transactionId' => $paymentDetails->getTransactionId(),
            'dateOfCreating' => $paymentDetails->getDateOfCreating(),
            'amount' => $paymentDetails->getAmount(),
            'currency' => $paymentDetails->getCurrency(),
            'cardDetails' => [
                'cardBin' => $paymentDetails->getCardDetails()->getCardBin(),
                'cardExpYear' => $paymentDetails->getCardDetails()->getCardExpYear(),
                'cardExpMonth' => $paymentDetails->getCardDetails()->getCardExpMonth()
            ]
        ];
    }
}
