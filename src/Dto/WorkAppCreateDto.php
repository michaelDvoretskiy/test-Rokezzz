<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class WorkAppCreateDto extends AbstractJsonRequest
{
    #[Assert\NotBlank (message: 'Parameter should be passed')]
    #[Assert\Length(min: 2, max: 50, minMessage: "Should be at least 2 symbols", maxMessage: "Should be no longer than 50 symbols")]
    public readonly string $firstName;
    #[Assert\NotBlank (message: 'Parameter should be passed')]
    #[Assert\Length(min: 2, max: 70, minMessage: "Should be at least 2 symbols", maxMessage: "Should be no longer than 70 symbols")]
    public readonly string $lastName;
    #[Assert\NotBlank (message: 'Parameter should be passed')]
    #[Assert\Length(min: 2, max: 150, minMessage: "Should be at least 2 symbols", maxMessage: "Should be no longer than 150 symbols")]
    public readonly string $position;
    #[Assert\NotBlank (message: 'Parameter should be passed')]
    #[Assert\Length(min: 2, max: 50, minMessage: "Should be at least 2 symbols", maxMessage: "Should be no longer than 50 symbols")]
    #[Assert\Email(message: "This field value should be a valid email")]
    public readonly string $email;
    #[Assert\NotBlank (message: 'Parameter should be passed')]
    #[Assert\Length(min: 2, max: 20, minMessage: "Should be at least 2 symbols", maxMessage: "Should be no longer than 20 symbols")]
    public readonly string $phone;
    #[Assert\NotBlank (message: 'Parameter should be passed')]
//    #[Assert\Type (type: "number", message: 'Should be a number')]
    #[Assert\Range(
        min: 1,
        max: 100000,
        notInRangeMessage: 'It must be between {{ min }} and {{ max }}',
    )]
    public readonly string $salary;
    #[Assert\IsTrue(message: 'phone parameter should contain only numbers')]
    private function isPhone()
    {
        return ctype_digit($this->phone);
    }

}