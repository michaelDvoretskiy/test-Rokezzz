<?php

namespace App\Service;

use App\Entity\WorkApplication;
use App\ServiceInterface\WorkApplicationServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class WorkApplicationService implements WorkApplicationServiceInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function getWorkAppList(string $orderField, string $orderType): array {
        return $this->em
            ->getRepository(WorkApplication::class)
            ->getAllWithOrder($orderField, $orderType);
    }
}