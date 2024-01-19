<?php

namespace App\Controller;

use App\ServiceInterface\WorkApplicationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/work-application', name: 'work_app_')]
class WorkApplicationController extends AbstractController
{
    public function __construct(
        private WorkApplicationServiceInterface $workApplicationService,
        private SerializerInterface $serializer
    )
    {

    }

    #[Route('', name: 'get_list', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $orderField = $request->query->get('orderBy', '');
        $orderType = $request->query->get('orderDir', 'asc');
        return new JsonResponse($this->serializer->serialize(
            $this->workApplicationService->getWorkAppList($orderField, $orderType),
            'json',
            ['groups' => ['workAppList']]
        ), 200, [], true);
    }

    #[Route('/new', name: 'get_new', methods: ['GET'])]
    public function getNew(): JsonResponse
    {
        return $this->json([
            'message' => 'This is the list of new work applications!',
        ]);
    }

    #[Route('/{workAppId}', name: 'get_one', methods: ['GET'], requirements: ['workAppId' => '\d+'])]
    public function getOne(int $workAppId): JsonResponse
    {
        return $this->json([
            'message' => 'This is the work application with id '.$workAppId.'!',
        ]);
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        return $this->json([
            'message' => 'This is the adding work application !',
            'data' => json_decode($request->getContent(), true)
        ]);
    }

    #[Route('/{workAppId}', name: 'edit_one', methods: ['PUT'], requirements: ['workAppId' => '\d+'])]
    public function edit(Request $request, int $workAppId): JsonResponse
    {
        return $this->json([
            'message' => 'Editing the work application with id '.$workAppId.'!',
            'data' => json_decode($request->getContent(), true)
        ]);
    }

    #[Route('/{workAppId}', name: 'remove_one', methods: ['DELETE'], requirements: ['workAppId' => '\d+'])]
    public function remove(int $workAppId): JsonResponse
    {
        return $this->json([
            'message' => 'Removing the work application with id '.$workAppId.'!'
        ]);
    }
}
