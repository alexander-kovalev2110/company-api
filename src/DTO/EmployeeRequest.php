<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class EmployeeRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name = '';

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email = '';

    #[Assert\NotNull]
    #[Assert\Positive]
    public int $companyId;
}