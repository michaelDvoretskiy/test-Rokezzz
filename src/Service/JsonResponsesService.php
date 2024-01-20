<?php

namespace App\Service;

use App\ServiceInterface\JsonResponsesServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponsesService implements JsonResponsesServiceInterface
{
    public function validationError(array $errors): void
    {
        $response = new JsonResponse(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->send();
        exit;
    }

    public function generalError(): void
    {
        $response = new JsonResponse(['message' => 'Somethoing went wrong'], Response::HTTP_BAD_REQUEST);
        $response->send();
        exit;
    }

    public function success(array|string $data = ['success' => true]): JsonResponse
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
}