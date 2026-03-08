<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class EmployeeRequest
{
    #[Assert\NotBlank]
    public string $name = '';

    #[Assert\Email]
    public string $email = '';

    #[Assert\NotNull]
    public int $companyId;
}
