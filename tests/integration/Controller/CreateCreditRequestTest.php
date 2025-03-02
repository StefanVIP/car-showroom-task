<?php

namespace App\Tests\integration\Controller;

use App\Repository\CreditRequestRepository;

class CreateCreditRequestTest extends AppTestCase
{
    /**@throws \Exception */
    public function testCreateCreditRequestSuccess(): void
    {
        /** @var CreditRequestRepository $creditRequestRepository */
        $creditRequestRepository = static::getContainer()->get(CreditRequestRepository::class);
        $numberOfCreditRequestsBefore = count($creditRequestRepository->findAll());

        $this->post(
            '/api/v1/credit/request',
            [
                'carId' => 1,
                'programId' => 1,
                'initialPayment' => 8700,
                'loanTerm' => 24,
            ],
        );

        $this->assertResponseStatusCodeSame(201);

        $response = $this->getResponseJSON();

        $this->assertTrue($response->success);

        $numberOfCreditRequestsAfter = count($creditRequestRepository->findAll());

        $this->assertGreaterThan($numberOfCreditRequestsBefore, $numberOfCreditRequestsAfter);
    }

    public function testCreateCreditRequestFailedWithoutNecessaryParameter(): void
    {
        $this->post(
            '/api/v1/credit/request',
            [
                'carId' => 1,
                'programId' => 1,
                'initialPayment' => 8700,
            ],
        );

        $this->assertResponseStatusCodeSame(400);
    }

    public function testCreateCreditRequestFailedWithWrongCardId(): void
    {
        $this->post(
            '/api/v1/credit/request',
            [
                'carId' => 1000,
                'programId' => 1,
                'initialPayment' => 8700,
                'loanTerm' => 24,
            ],
        );

        $this->assertResponseStatusCodeSame(404);
    }

    public function testCreateCreditRequestFailedWithWrongProgramId(): void
    {
        $this->post(
            '/api/v1/credit/request',
            [
                'carId' => 1,
                'programId' => 1000,
                'initialPayment' => 8700,
                'loanTerm' => 24,
            ],
        );

        $this->assertResponseStatusCodeSame(404);
    }
}
