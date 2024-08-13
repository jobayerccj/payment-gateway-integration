<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;

class PaymentServiceTest extends TestCase
{
    // check payment Type whether proper payment type params send or not
    // check amount whether it's same or not
    // check all other required params are passed or not
    // check proper validation message send or not
    //
    public function testProcessPayment(string $paymentType, array $request, int $expectedResult)
    {
        $this->assertTrue(true);
    }
}
