<?php

namespace App\Service;

use App\Entity\Company;
use App\DTO\CompanyRequest;
use Doctrine\ORM\EntityManagerInterface;

class CompanyService
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function create(CompanyRequest $dto): Company
    {
        $company = new Company();
        $company->setName($dto->name);
        $company->setEmail($dto->email);

        $this->em->persist($company);
        $this->em->flush();

        return $company;
    }

    public function update(Company $company, CompanyRequest $dto): Company
    {
        $company->setName($dto->name);
        $company->setEmail($dto->email);

        $this->em->flush();

        return $company;
    }

    public function delete(Company $company): void
    {
        $this->em->remove($company);
        $this->em->flush();
    }
}