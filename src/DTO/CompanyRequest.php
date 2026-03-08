<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CompanyRequest
{
    #[Assert\NotBlank]
    public string $name = '';

    #[Assert\Email]
    public string $email = '';
}