<?php

namespace App\Controller;

use App\Dto\WorkAppCreateDto;
use App\Dto\WorkAppGetRequestDto;
use App\ServiceInterface\JsonResponsesServiceInterface;
use App\ServiceInterface\WorkAppEditServiceInterface;
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
        private WorkAppEditServiceInterface $workAppEditService,
        private SerializerInterface $serializer,
        private JsonResponsesServiceInterface $jsonResponsesService
    )
    {

    }

    #[Route('', name: 'get_viewed', methods: ['GET'])]
    public function index(WorkAppGetRequestDto $appGetRequestDto): JsonResponse
    {
        return $this->jsonResponsesService->success(
            $this->serializer->serialize(
                $this->workApplicationService->getViewedWorkAppList($appGetRequestDto),
                'json',
                ['groups' => ['workAppList']]
            )
        );
    }

    #[Route('/new', name: 'get_new', methods: ['GET'])]
    public function getNew(WorkAppGetRequestDto $appGetRequestDto): JsonResponse
    {
        return $this->jsonResponsesService->success(
            $this->serializer->serialize(
                $this->workApplicationService->getNewWorkAppList($appGetRequestDto),
                'json',
                ['groups' => ['workAppList']]
            )
        );
    }

    #[Route('/{workAppId}', name: 'get_one', methods: ['GET'], requirements: ['workAppId' => '\d+'])]
    public function getOne(int $workAppId, WorkAppGetRequestDto $appGetRequestDto): JsonResponse
    {
        return $this->jsonResponsesService->success(
            $this->serializer->serialize(
                $this->workApplicationService->getOneWorkApp($workAppId, $appGetRequestDto),
                'json',
                ['groups' => ['oneWorkApp']]
            )
        );
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function add(WorkAppCreateDto $appCreateDto): JsonResponse
    {
        $newId = $this->workAppEditService->addWorkApp($appCreateDto);
        if (!$newId) {
            $this->jsonResponsesService->generalError();
        }

        return $this->jsonResponsesService->success(['id' => $newId]);
    }

    #[Route('/{workAppId}', name: 'edit_one', methods: ['PUT'], requirements: ['workAppId' => '\d+'])]
    public function edit(int $workAppId, WorkAppCreateDto $appCreateDto): JsonResponse
    {
        if (!$this->workAppEditService->editWorkApp($workAppId, $appCreateDto)) {
            $this->jsonResponsesService->generalError();
        }
        return $this->jsonResponsesService->success();
    }

    #[Route('/{workAppId}', name: 'remove_one', methods: ['DELETE'], requirements: ['workAppId' => '\d+'])]
    public function remove(int $workAppId): JsonResponse
    {
        if (!$this->workAppEditService->removeWorkApp($workAppId)) {
            $this->jsonResponsesService->generalError();
        }
        return $this->jsonResponsesService->success();
    }
}
