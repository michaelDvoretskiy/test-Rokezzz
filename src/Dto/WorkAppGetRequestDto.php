<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class WorkAppGetRequestDto extends AbstractJsonRequest
{
    #[Assert\Choice(choices: ['firstName', 'lastName', 'position', 'level'], message: 'Not acceptable value')]
    public readonly string $orderBy;
    #[Assert\Choice(choices: ['asc', 'desc'], message: 'Not acceptable value')]
    public readonly string $orderDir;
    public readonly string $userId;
    #[Assert\IsTrue(message: 'userId parameter should be a number')]
    private function isUserId()
    {
        return !isset($this->userId) || ctype_digit($this->userId);
    }

}