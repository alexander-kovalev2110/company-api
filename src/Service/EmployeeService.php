<?php

namespace App\Service;

use App\Entity\Employee;
use App\DTO\EmployeeRequest;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeService
{
    public function __construct(
        private EntityManagerInterface $em,
        private CompanyRepository $companyRepository
    ) {}

    public function create(EmployeeRequest $dto): Employee
    {
        $employee = new Employee();
        $employee->setName($dto->name);
        $employee->setEmail($dto->email);

        $company = $this->companyRepository->find($dto->companyId);
        if (!$company) {
            throw new NotFoundHttpException('Company not found');
        }

        $employee->setCompany($company);

        $this->em->persist($employee);
        $this->em->flush();

        return $employee;
    }

    public function update(Employee $employee, EmployeeRequest $dto): Employee
    {
        $employee->setName($dto->name);
        $employee->setEmail($dto->email);

        $company = $this->companyRepository->find($dto->companyId);
        if (!$company) {
            throw new NotFoundHttpException('Company not found');
        }
        
        $employee->setCompany($company);

        $this->em->flush();

        return $employee;
    }

    public function delete(Employee $employee): void
    {
        $this->em->remove($employee);
        $this->em->flush();
    }
}
