<?php

namespace App\Service;

use App\Dto\WorkAppGetRequestDto;
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

    private function getOrder(WorkAppGetRequestDto $appGetRequestDto): array
    {
        return [
            $appGetRequestDto->orderBy ?? '',
            $appGetRequestDto->orderDir ?? 'asc'
        ];
    }
}