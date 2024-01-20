<?php

namespace App\ServiceInterface;

use Symfony\Component\HttpFoundation\JsonResponse;

interface JsonResponsesServiceInterface
{
    public function validationError(array $errors): void;
    public function generalError(): void;
    public function success(array|string $data = []): JsonResponse;
}