<?php

namespace App\Service;

use App\Dto\WorkAppGetRequestDto;
use App\Entity\ViewedWorkApp;
use App\Entity\WorkApplication;
use App\ServiceInterface\WorkApplicationServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class WorkApplicationService implements WorkApplicationServiceInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function getViewedWorkAppList(WorkAppGetRequestDto $appGetRequestDto): array
    {
        list($orderBy, $orderDir) = $this->getOrder($appGetRequestDto);
        if(isset($appGetRequestDto->userId)) {
            return $this->em
                ->getRepository(WorkApplication::class)
                ->getViewedWithOrder($appGetRequestDto->userId, $orderBy, $orderDir);
        }

        return $this->em
            ->getRepository(WorkApplication::class)
            ->getOldWithOrder($orderBy, $orderDir);
    }

    public function getNewWorkAppList(WorkAppGetRequestDto $appGetRequestDto): array
    {
        list($orderBy, $orderDir) = $this->getOrder($appGetRequestDto);
        if(isset($appGetRequestDto->userId)) {
            return $this->em
                ->getRepository(WorkApplication::class)
                ->getUnviewedWithOrder($appGetRequestDto->userId, $orderBy, $orderDir);
        }

        return $this->em
            ->getRepository(WorkApplication::class)
            ->getNewWithOrder($orderBy, $orderDir);
    }

    public function getOneWorkApp(int $workAppId, WorkAppGetRequestDto $appGetRequestDto): ?WorkApplication
    {
        $workApp = $this->em->getRepository(WorkApplication::class)->find($workAppId);
        if ($workApp && isset($appGetRequestDto->userId)) {
            $workAppViewed = $this->em->getRepository(ViewedWorkApp::class)
                ->findOneBy([
                    'UserId' => $appGetRequestDto->userId,
                    'workApp' => $workApp
                ]);
            if (!$workAppViewed) {
                $workAppViewed = (new ViewedWorkApp())
                    ->setUserId($appGetRequestDto->userId)
                    ->setWorkApp($workApp);
                $this->em->persist($workAppViewed);
                $this->em->flush();
            }
        }
        return $this->em->getRepository(WorkApplication::class)->find($workAppId);
    }

    private function getOrder(WorkAppGetRequestDto $appGetRequestDto): array
    {
        return [
            $appGetRequestDto->orderBy ?? '',
            $appGetRequestDto->orderDir ?? 'asc'
        ];
    }
}