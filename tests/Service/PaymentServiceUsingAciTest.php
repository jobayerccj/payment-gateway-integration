<?php

namespace App\Tests\Service;

use App\DTO\CardDTO;
use App\DTO\PaymentResponseDTO;
use App\Factory\PaymentProcessorFactory;
use App\Interface\PaymentProcessorInterface;
use App\Service\DataValidator;
use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaymentServiceUsingAciTest extends KernelTestCase
{
    private PaymentService $paymentService;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $container = static::getContainer();
        $validator = $container->get(ValidatorInterface::class);
        $dataValidator = new DataValidator($validator);

        $paymentProcessorMock = $this->createMock(PaymentProcessorInterface::class);
        $paymentDetails = new PaymentResponseDTO();
        $paymentDetails->setTransactionId('8ac7a4a0914aa6a001914d4fa2c43c5c');
        $paymentDetails->setDateOfCreating(new \DateTime('now'));
        $paymentDetails->setAmount(123.3);
        $paymentDetails->setCurrency('EUR');
        $cardDTO = new CardDTO('424242', 2032, '05');
        $paymentDetails->setCardDetails($cardDTO);

        $paymentProcessorMock
            ->method('getPaymentDetails')
            ->willReturn($paymentDetails);

        $paymentMethodFactoryMock = $this->createMock(PaymentProcessorFactory::class);
        $paymentMethodFactoryMock
            ->method('getPaymentProcessor')
            ->willReturn($paymentProcessorMock);

        $this->paymentService = new PaymentService($dataValidator, $paymentMethodFactoryMock);
    }

    /**
     * @dataProvider paymentRequestsProvider
     */
    public function testProcessPaymentThrowsValidationException(string $paymentType, array $request)
    {
        $this->expectException(ValidationFailedException::class);
        $this->paymentService->processPayment($paymentType, $request);
    }

    /**
     * @dataProvider paymentRequestsProviderWithResult
     */
    public function testTotalErrorsMatchesWithValidationExceptions(string $paymentType, array $request, int $expectedCount)
    {
        try {
            $this->paymentService->processPayment($paymentType, $request);
        } catch (ValidationFailedException $e) {
            $violations = $e->getViolations();

            $this->assertCount($expectedCount, $violations);

            return;
        }
    }

    public static function paymentRequestsProvider(): array
    {
        $requests = [];
        $dummyRequests = self::dummyPaymentRequests();
        foreach ($dummyRequests as $dummyRequest) {
            $requests[] = ['aci', $dummyRequest['data']];
        }

        return $requests;
    }

    public static function paymentRequestsProviderWithResult(): array
    {
        $requests = [];
        $dummyRequests = self::dummyPaymentRequests();
        foreach ($dummyRequests as $dummyRequest) {
            $requests[] = ['aci', $dummyRequest['data'], $dummyRequest['totalViolations']];
        }

        return $requests;
    }

    private static function dummyPaymentRequests(): array
    {
        return [
            [
                'data' => [
                    'currency' => 'EUR',
                    'cardNumber' => '4242424242424242',
                    'cardExpYear' => 2032,
                    'cardExpMonth' => '12',
                    'cardCvv' => '123',
                ],
                'totalViolations' => 1,
            ],
            [
                'data' => [
                    'amount' => 'asd',
                    'currency' => 'EUR',
                    'cardNumber' => '4242424242424242',
                    'cardExpYear' => 2032,
                    'cardExpMonth' => '12',
                    'cardCvv' => '123',
                ],
                'totalViolations' => 1,
            ],
            [
                'data' => [
                    'amount' => 'asd',
                    'cardNumber' => '4242424242424242',
                    'cardExpYear' => 2032,
                    'cardExpMonth' => '12',
                ],
                'totalViolations' => 3,
            ],
            [
                'data' => [
                    'amount' => 564,
                    'cardCvv' => '123',
                ],
                'totalViolations' => 4,
            ],
            [
                'data' => [
                    'amount' => 564,
                    'currency' => 'EUR',
                    'cardCvv' => '123',
                ],
                'totalViolations' => 3,
            ],
            [
                'data' => [],
                'totalViolations' => 6,
            ],
        ];
    }

    public function testProcessPaymentSuccessful()
    {
        $request = [
            'amount' => 123.3,
            'currency' => 'EUR',
            'cardNumber' => '4242424242424242',
            'cardExpYear' => 2032,
            'cardExpMonth' => '12',
            'cardCvv' => '123',
        ];

        $response = $this->paymentService->processPayment('aci', $request);
        $this->assertArrayHasKey('transactionId', $response);
        $this->assertArrayHasKey('dateOfCreating', $response);
        $this->assertArrayHasKey('amount', $response);
        $this->assertArrayHasKey('currency', $response);
        $this->assertArrayHasKey('cardBin', $response);

        $this->assertEquals($request['amount'], $response['amount']);
    }
}
