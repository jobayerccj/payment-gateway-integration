<?php

namespace App\Controller\api\v1;

use App\Controller\BaseController;
use App\Service\DataValidator;
use App\Service\PaymentService;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;
use Shift4\Exception\Shift4Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[Route('/api/v1')]
class PaymentController extends BaseController
{
    public function __construct(private readonly PaymentService $paymentService, private readonly DataValidator $dataValidator, protected LoggerInterface $logger)
    {
        parent::__construct($this->logger);
    }

    #[Route('/payment/{paymentType}', name: 'app_api_v1_initiate_payment', methods: ['POST'])]
    public function initiatePayment(string $paymentType, Request $request): JsonResponse
    {
        try {
            $paymentDetails = $this->paymentService->processPayment($paymentType, $request->toArray());
            return $this->jsonOk([$paymentDetails]);
        } catch (ValidationFailedException $exc) {
            return $this->jsonError(
                $this->dataValidator->processErrors($exc->getViolations()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (NotFoundHttpException|RequestException $exc) {
            return $this->jsonError($exc->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Shift4Exception $exc) {
            return $this->jsonError("Wrong parameter passed, please check payment information", Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $exc) {
            return $this->jsonError($exc->getMessage());
        }
    }
}
