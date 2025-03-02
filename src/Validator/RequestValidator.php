<?php

namespace App\Validator;

use App\Application\Exception\BadRequestException;
use App\Exception\HttpRequestValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class RequestValidator
{
    private DenormalizerInterface $denormalizer;
    private ValidatorInterface $validator;
    private LoggerInterface $logger;

    public function __construct(
        DenormalizerInterface $denormalizer,
        ValidatorInterface $validator,
        LoggerInterface $logger
    ) {
        $this->denormalizer = $denormalizer;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * @param mixed[] $data
     * @param string $dtoClass
     * @return object
     */
    public function validateAndDenormalize(array $data, string $dtoClass): object
    {
        try {
            $dto = $this->denormalizer->denormalize(
                $data,
                $dtoClass,
                JsonEncoder::FORMAT,
                [AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => false],
            );
            $this->logger->debug('DTO успешно десериализован.', ['dto' => $dto]);
        } catch (MissingConstructorArgumentsException $e) {
            $this->logger->error('Отсутствуют обязательные параметры.', [
                'missing_arguments' => $e->getMissingConstructorArguments(),
            ]);
            throw new BadRequestHttpException(
                sprintf(
                    'Отсутствуют обязательные параметры: %s',
                    implode(', ', $e->getMissingConstructorArguments()),
                ),
                $e,
                (int)$e->getCode(),
            );
        } catch (Throwable $e) {
            $this->logger->error('Ошибка при десериализации.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw new BadRequestHttpException($e->getMessage(), $e, (int)$e->getCode());
        }

        $violations = $this->validator->validate($dto);
        if (count($violations) > 0) {
            $this->logger->error('Ошибка валидации DTO.', [
                'violations' => $violations,
            ]);
            throw new HttpRequestValidationException($violations);
        }

        return $dto;
    }
}
