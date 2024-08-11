<?php

namespace App\Controller\api\v1;

use App\Service\PaymentService;
use Exception;
use Shift4\Exception\Shift4Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class PaymentController extends AbstractController
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    #[Route('/payment/{paymentMethod}', name: 'app_api_v1_initiate_payment', methods: ['POST'])]
    public function initiatePayment(string $paymentMethod, Request $request): JsonResponse
    {
        try {
            $paymentDetails = $this->paymentService->processPayment($paymentMethod, $request->toArray());
            return new JsonResponse([
                'success' => 'true',
                'amount' => $paymentDetails->getAmount(),
                'currency' => $paymentDetails->getCurrency()
            ]);
        } catch (Shift4Exception $exception) {
            return new JsonResponse([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        } catch (Exception $exception) {
            return new JsonResponse([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }

    }
}
