<?php

namespace App\Tests\integration\Controller;

class GetCreditCalculationTest extends AppTestCase
{
    /** @throws \JsonException */
    public function testGetCreditCalculationSuccess(): void
    {
        $this->get(
            '/api/v1/credit/calculate?price=1401000&initialPayment=210000&loanTerm=60&permissibleMonthlyPayment=9000',
        );

        $this->assertResponseStatusCodeSame(200);

        $response = $this->getResponseJSON();

        $this->assertObjectHasProperty('programId', $response);
        $this->assertIsInt($response->programId);
        $this->assertObjectHasProperty('monthlyPayment', $response);
        $this->assertIsInt($response->monthlyPayment);
        $this->assertObjectHasProperty('monthlyPayment', $response);
        $this->assertIsInt($response->monthlyPayment);
    }

    public function testGetCreditCalculationFailedWithInvalidParameter(): void
    {
        $this->get('/api/v1/credit/calculate?price=invalid');

        $this->assertResponseStatusCodeSame(400);
    }
}
