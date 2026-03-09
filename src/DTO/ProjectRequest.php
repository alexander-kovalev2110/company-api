<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ProjectRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name = '';

    #[Assert\NotBlank]
    #[Assert\Length(min: 5)]
    public string $description = '';

    #[Assert\NotNull]
    #[Assert\Positive]
    public int $companyId;
}