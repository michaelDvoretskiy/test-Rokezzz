<?php

namespace App\ServiceInterface;

use App\Dto\WorkAppCreateDto;
use App\Dto\WorkAppGetRequestDto;
use App\Entity\WorkApplication;

interface WorkAppEditServiceInterface
{
    public function addWorkApp(WorkAppCreateDto $appCreateDto): int;

    public function editWorkApp(int $workAppId, WorkAppCreateDto $appCreateDto): bool;

    public function removeWorkApp(int $workAppId): bool;
}