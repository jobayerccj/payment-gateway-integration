<?php

namespace App\PaymentMethod;

use App\DTO\PaymentRequestDTO;
use App\Interface\PaymentMethod;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AciPayment implements PaymentMethod
{
    public function initiatePayment(PaymentRequestDTO $paymentRequestDTO)
    {
        return $this->preAuthorizePayment($paymentRequestDTO);
    }

    private function preAuthorizePayment(PaymentRequestDTO $paymentRequestDTO)
    {
        try {
            $client = new Client(['base_uri' => 'https://eu-test.oppwa.com/v1/']);
            $response = $client->request('POST', 'payments', [
                'form_params' => [
                    'entityId' => "8a8294174b7ecb28014b9699220015ca",
                    'amount' => $paymentRequestDTO->getAmount(),
                    'currency' => $paymentRequestDTO->getCurrency(),
                    'paymentBrand' => 'VISA',
                    'paymentType' => 'DB',
                    'card.number' => $paymentRequestDTO->getCardNumber(),
                    'card.holder' => 'Jane Jones',
                    'card.expiryMonth' => $paymentRequestDTO->getCardExpMonth(),
                    'card.expiryYear' => $paymentRequestDTO->getCardExpYear(),
                    'card.cvv' => $paymentRequestDTO->getCardCvv()
                ],
                'headers' => [
                    'Authorization' => "Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=",
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

    private function findRequestErrors(array $parameterErrors): string
    {
        $errorsDetails = "";
        foreach ($parameterErrors as $key => $error) {
            $errorsDetails .= sprintf("%d. %s %s ", $key+1, $error->name, $error->message);
        }

        return $errorsDetails;
    }
}
