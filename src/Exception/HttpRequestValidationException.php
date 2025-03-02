<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class HttpRequestValidationException extends BadRequestHttpException
{
    private ConstraintViolationListInterface $violations;

    public function __construct(ConstraintViolationListInterface $violations, \Exception $previous = null)
    {
        $this->violations = $violations;

        parent::__construct(
            sprintf('Validation errors: %s', $this->violationsToString($violations)),
            $previous,
            Response::HTTP_BAD_REQUEST,
        );
    }

    private function violationsToString(ConstraintViolationListInterface $violations): string
    {
        $items = [];

        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $items[$violation->getPropertyPath()][] = (string)$violation->getMessage();
        }

        return implode(
            '; ',
            array_map(
                fn(array $errors, string $property) => sprintf('%s - [%s]', $property, implode(' | ', $errors)),
                $items,
                array_keys($items),
            ),
        );
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
