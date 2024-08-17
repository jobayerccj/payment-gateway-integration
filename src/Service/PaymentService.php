<?php

namespace App\Service;

use App\DTO\PaymentRequestDTO;
use App\DTO\PaymentResponseDTO;
use App\Factory\PaymentProcessorFactory;

class PaymentService
{
    public function __construct(
        protected DataValidator $dataValidator,
        protected PaymentProcessorFactory $paymentProcessorFactory
    ) {
    }

    public function processPayment(string $paymentType, array $request): array
    {
        $paymentRequestData = $this->getPaymentRequestDTO($paymentType, $request);
        $this->dataValidator->validateData($paymentRequestData);
        $paymentProcessor = $this->paymentProcessorFactory->getPaymentProcessor($paymentType);
        $paymentDetails = $paymentProcessor->getPaymentDetails($paymentRequestData);

        return $this->findPaymentResponse($paymentDetails);
    }

    private function getPaymentRequestDTO(string $paymentType, array $request): PaymentRequestDTO
    {
        $paymentRequestData = new PaymentRequestDTO();
        $paymentRequestData->setPaymentType($paymentType);

        if (isset($request['amount'])) {
            $paymentRequestData->setAmount((float) $request['amount']);
        }

        if (isset($request['currency'])) {
            $paymentRequestData->setCurrency($request['currency']);
        }

        if (isset($request['cardNumber'])) {
            $paymentRequestData->setCardNumber($request['cardNumber']);
        }

        if (isset($request['cardExpYear'])) {
            $paymentRequestData->setCardExpYear($request['cardExpYear']);
        }

        if (isset($request['cardExpMonth'])) {
            $paymentRequestData->setCardExpMonth($request['cardExpMonth']);
        }

        if (isset($request['cardCvv'])) {
            $paymentRequestData->setCardCvv($request['cardCvv']);
        }

        return $paymentRequestData;
    }

    private function findPaymentResponse(PaymentResponseDTO $paymentDetails): array
    {
        return [
            'transactionId' => $paymentDetails->getTransactionId(),
            'dateOfCreating' => $paymentDetails->getDateOfCreating(),
            'amount' => $paymentDetails->getAmount(),
            'currency' => $paymentDetails->getCurrency(),
            'cardBin' => $paymentDetails->getCardDetails()->getCardBin(),
        ];
    }
}
