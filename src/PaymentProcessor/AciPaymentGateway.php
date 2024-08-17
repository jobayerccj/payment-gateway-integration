<?php

namespace App\PaymentProcessor;

use App\DTO\CardDTO;
use App\DTO\PaymentRequestDTO;
use App\DTO\PaymentResponseDTO;
use App\Interface\PaymentProcessorInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class AciPaymentGateway implements PaymentProcessorInterface
{
    /**
     * @throws GuzzleException
     */
    public function getPaymentDetails(PaymentRequestDTO $paymentRequestDTO): ?PaymentResponseDTO
    {
        $initialData = $this->initiatePayment($paymentRequestDTO);
        $paymentDetails = $this->convertPaymentDetailsToDTO($initialData);

        return $paymentDetails;
    }
    /**
     * @throws GuzzleException
     */
    public function initiatePayment(PaymentRequestDTO $paymentRequestDTO)
    {
        try {
            $client = new Client(['base_uri' => 'https://eu-test.oppwa.com/v1/']);
            $response = $client->request('POST', 'payments', [
                'form_params' => [
                    'entityId' => '8a8294174b7ecb28014b9699220015ca',
                    'amount' => $paymentRequestDTO->getAmount(),
                    'currency' => $paymentRequestDTO->getCurrency(),
                    'paymentBrand' => 'VISA',
                    'paymentType' => 'DB',
                    'card.number' => $paymentRequestDTO->getCardNumber(),
                    'card.holder' => 'Jane Jones',
                    'card.expiryMonth' => $paymentRequestDTO->getCardExpMonth(),
                    'card.expiryYear' => $paymentRequestDTO->getCardExpYear(),
                    'card.cvv' => $paymentRequestDTO->getCardCvv(),
                ],
                'headers' => [
                    'Authorization' => 'Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=',
                ],
                'verify' => false,
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $exc) {
            $errorDetails = json_decode($exc->getResponse()->getBody()->getContents());
            $errors = $this->findRequestErrors($errorDetails->result->parameterErrors);
            throw new RequestException($errors, $exc->getRequest(), $exc->getResponse());
        }
    }

    /**
     * @throws \Exception
     */
    public function convertPaymentDetailsToDTO($initialData): ?PaymentResponseDTO
    {
        $paymentResponseDTO = new PaymentResponseDTO();
        $creatingDate = new \DateTime($initialData->timestamp);
        $cardDetails = new CardDTO($initialData->card->bin, $initialData->card->expiryYear, $initialData->card->expiryMonth);
        $paymentResponseDTO
            ->setTransactionId($initialData->id)
            ->setDateOfCreating($creatingDate)
            ->setAmount((float) $initialData->amount)
            ->setCurrency($initialData->currency)
            ->setCardDetails($cardDetails)
        ;

        return $paymentResponseDTO;
    }

    private function findRequestErrors(array $parameterErrors): string
    {
        $errorsDetails = '';
        foreach ($parameterErrors as $key => $error) {
            $errorsDetails .= sprintf('%d. %s %s ', $key + 1, $error->name, $error->message);
        }

        return $errorsDetails;
    }

}
