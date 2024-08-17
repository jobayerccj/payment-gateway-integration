<?php

namespace App\PaymentProcessor;

use App\DTO\CardDTO;
use App\DTO\PaymentRequestDTO;
use App\DTO\PaymentResponseDTO;
use App\Interface\PaymentProcessorInterface;
use Shift4\Exception\Shift4Exception;
use Shift4\Request\ChargeRequest;
use Shift4\Response\Charge;
use Shift4\Shift4Gateway;

class Shift4PaymentGateway implements PaymentProcessorInterface
{
    /**
     * @throws Shift4Exception
     */
    public function getPaymentDetails(PaymentRequestDTO $paymentRequestDTO): ?PaymentResponseDTO
    {
        $initialData = $this->initiatePayment($paymentRequestDTO);
        $paymentDetails = $this->convertPaymentDetailsToDTO($initialData);

        return $paymentDetails;
    }

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

    public function convertPaymentDetailsToDTO($initialData): ?PaymentResponseDTO
    {
        $paymentResponseDTO = new PaymentResponseDTO();
        $creatingDate = new \DateTime();
        $card = $initialData->getCard();
        $cardDetails = new CardDTO($card->getFirst6(), $card->getExpYear(), $card->getExpMonth());

        $paymentResponseDTO
            ->setTransactionId($initialData->getId())
            ->setDateOfCreating($creatingDate->setTimestamp($initialData->getCreated()))
            ->setAmount((float) $initialData->getAmount())
            ->setCurrency($initialData->getCurrency())
            ->setCardDetails($cardDetails)
        ;

        return $paymentResponseDTO;
    }
}
