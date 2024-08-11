<?php

namespace App\Controller\PaymentMethod;

use App\DTO\PaymentRequestDTO;
use App\DTO\PaymentResponseDTO;
use App\Interface\PaymentMethod;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

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
                    'card.number' => 4200000000000000,
                    'card.holder' => 'Jane Jones',
                    'card.expiryMonth' => '05',
                    'card.expiryYear' => 2034,
                    'card.cvv' => 123
                ],
                'headers' => [
                    'Authorization' => "Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=",
                ],
                'verify' => false,
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $exc) {
            throw new RequestException($exc->getMessage(), $exc->getRequest(), $exc->getResponse());
        }
    }
}
