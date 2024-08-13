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
        $paymentRequestData = new PaymentRequestDTO();
        $paymentRequestData
            ->setPaymentType(isset($paymentType) ? $paymentType : '')
            ->setAmount(isset($request['amount']) ? (float) $request['amount'] : 0)
            ->setCurrency(isset($request['currency']) ? $request['currency'] : '')
            ->setCardNumber(isset($request['cardNumber']) ? $request['cardNumber'] : '')
            ->setCardExpYear(isset($request['cardExpYear']) ? (int) $request['cardExpYear'] : 2023)
            ->setCardExpMonth(isset($request['cardExpMonth']) ? $request['cardExpMonth'] : '')
            ->setCardCvv(isset($request['cardCvv']) ? $request['cardCvv'] : '')
        ;

        $this->dataValidator->validateData($paymentRequestData);
        $paymentMethod = PaymentMethodFactory::getPaymentMethod($paymentType);
        $initialData = $paymentMethod->initiatePayment($paymentRequestData);
        $paymentMethodAdapter = PaymentAdapterFactory::getPaymentAdapter($paymentType);
        $paymentDetails = $paymentMethodAdapter->convertPaymentDetailsToDTO($initialData);
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
