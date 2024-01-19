<?php

namespace App\ServiceInterface;

interface WorkApplicationServiceInterface
{
    public function getWorkAppList(string $orderField, string $orderType): array;
}