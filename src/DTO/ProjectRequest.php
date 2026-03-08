<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ProjectRequest
{
    #[Assert\NotBlank]
    public string $name = '';

    #[Assert\NotBlank]
    public string $description = '';

    #[Assert\NotNull]
    public int $companyId;
}
