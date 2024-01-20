<?php

namespace App\Service;

use App\Dto\WorkAppCreateDto;
use App\Entity\WorkApplication;
use App\ServiceInterface\WorkAppEditServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class WorkAppEditService implements WorkAppEditServiceInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
    }

    public function addWorkApp(WorkAppCreateDto $appCreateDto): int
    {
        $newWorkApp = $this->fillWorkAppFromDto(new WorkApplication(), $appCreateDto);
        try {
            $this->em->persist($newWorkApp);
            $this->em->flush();
        } catch(\Throwable $e) {
            return 0;
        }
        return $newWorkApp->getId();
    }

    public function editWorkApp(int $workAppId, WorkAppCreateDto $appCreateDto): bool
    {
        $workApp = $this->em->getRepository(WorkApplication::class)
            ->find($workAppId);
        if (!$workApp) {
            return false;
        }
        $workApp = $this->fillWorkAppFromDto($workApp, $appCreateDto);
        try {
            $this->em->flush();
        } catch(\Throwable $e) {
            return false;
        }
        return true;
    }

    public function removeWorkApp(int $workAppId): bool
    {
        $workApp = $this->em->getRepository(WorkApplication::class)
            ->find($workAppId);
        if (!$workApp) {
            return false;
        }
        try {
            $this->em->remove($workApp);
            $this->em->flush();
        } catch(\Throwable $e) {
            return false;
        }
        return true;
    }

    private function fillWorkAppFromDto(WorkApplication $workApplication, WorkAppCreateDto $workAppCreateDto): WorkApplication
    {
        return $workApplication
            ->setFirstName($workAppCreateDto->firstName)
            ->setLastName($workAppCreateDto->lastName)
            ->setEmail($workAppCreateDto->email)
            ->setPhone($workAppCreateDto->phone)
            ->setPosition($workAppCreateDto->position)
            ->setSalary($workAppCreateDto->salary)
            ->setCreatedAt(new \DateTime())
            ->setLevel("!!!");
    }
}