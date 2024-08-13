<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    public function __construct(protected LoggerInterface $logger) {}

    protected function jsonOk(array|null $data = null, array $metaData = []): JsonResponse
    {
        $responseData['status'] = 'ok';

        if (isset($data)) {
            $responseData['data'] = $data;
        }

        return $this->json(array_merge($responseData, $metaData));
    }

    protected function jsonError(mixed $errors, int $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR, int $errorCode = null): JsonResponse
    {
        if ($responseCode == Response::HTTP_INTERNAL_SERVER_ERROR) {
            $this->logger->critical(json_encode($errors));
        }

        return $this->json(
            [
                'status' => 'error',
                'errors' => $errors,
                'error_code' => $errorCode
            ],
            $responseCode
        );
    }
}
