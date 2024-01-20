<?php

namespace App\ServiceInterface;

use App\Dto\WorkAppGetRequestDto;

interface WorkApplicationServiceInterface
{
    public function getViewedWorkAppList(WorkAppGetRequestDto $appGetRequestDto): array;

    public function getNewWorkAppList(WorkAppGetRequestDto $appGetRequestDto): array;
}