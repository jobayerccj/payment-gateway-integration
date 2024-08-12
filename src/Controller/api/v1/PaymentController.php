<?php

namespace App\Controller\api\v1;

use App\Controller\BaseController;
use App\Service\DataValidator;
use App\Service\PaymentService;
use Exception;
use Shift4\Exception\Shift4Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[Route('/api/v1')]
class PaymentController extends BaseController
{
    public function __construct(private PaymentService $paymentService, private DataValidator $dataValidator)
    {}

    #[Route('/payment/{paymentMethod}', name: 'app_api_v1_initiate_payment', methods: ['POST'])]
    public function initiatePayment(string $paymentMethod, Request $request): JsonResponse
    {
        try {
            $paymentDetails = $this->paymentService->processPayment($paymentMethod, $request->toArray());
            return $this->jsonOk([$paymentDetails]);
        } catch (ValidationFailedException $exception) {
            return $this->jsonError($this->dataValidator->processErrors($exception->getViolations()), Response::HTTP_UNPROCESSABLE_ENTITY);
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
