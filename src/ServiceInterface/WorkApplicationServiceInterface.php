<?php

namespace App\ServiceInterface;

use App\Dto\WorkAppGetRequestDto;
use App\Entity\WorkApplication;

interface WorkApplicationServiceInterface
{
    public function getViewedWorkAppList(WorkAppGetRequestDto $appGetRequestDto): array;

    public function getNewWorkAppList(WorkAppGetRequestDto $appGetRequestDto): array;

    public function getOneWorkApp(int $workAppId, WorkAppGetRequestDto $appGetRequestDto): ?WorkApplication;
}