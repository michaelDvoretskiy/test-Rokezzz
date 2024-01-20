<?php

namespace App\Dto;

use App\ServiceInterface\JsonResponsesServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractJsonRequest
{
    protected bool $allowExtraFields = false;
    protected $extraFieldErrors = [];

    public function __construct(
        private readonly ValidatorInterface $validator,
        protected EntityManagerInterface $em,
        private readonly JsonResponsesServiceInterface $jsonResponsesService,
        private readonly RequestStack $requestStack,
    ) {
        $this->populate();
        $this->validate();
    }

    protected function populate(): void
    {
        $requestData = array_merge(
            $this->requestStack->getCurrentRequest()->query->all(),
            json_decode($this->requestStack->getCurrentRequest()->getContent(), true) ?? []
        );
        $reflection = new \ReflectionClass($this);

        foreach ($requestData as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $reflectionProperty = $reflection->getProperty($attribute);
                $reflectionProperty->setValue($this, $value);
            } elseif (!$this->allowExtraFields) {
                $this->extraFieldErrors[] = [
                    'property' => $attribute,
                    'value' => $value,
                    'message' => $attribute . " field is not allowed",
                ];
            }
        }
    }

    protected function validate(): void
    {
        $violations = $this->validator->validate($this);
        if (count($violations) < 1 && count($this->extraFieldErrors) < 1) {
            return;
        }

        $errors = [];

        /** @var \Symfony\Component\Validator\ConstraintViolation */
        foreach ($violations as $violation) {
            $attribute = $violation->getPropertyPath();
            $errors[] = [
                'property' => $attribute,
                'value' => $violation->getInvalidValue(),
                'message' => $violation->getMessage(),
            ];
        }

        $this->jsonResponsesService->validationError(array_merge($errors,$this->extraFieldErrors));
    }
}
