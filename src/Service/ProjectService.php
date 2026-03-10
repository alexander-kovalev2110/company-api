<?php

namespace App\Service;

use App\Entity\Project;
use App\DTO\ProjectRequest;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProjectService
{
    public function __construct(
        private EntityManagerInterface $em,
        private CompanyRepository $companyRepository
    ) {}

    public function create(ProjectRequest $dto): Project
    {
        $project = new Project();
        $project->setName($dto->name);
        $project->setDescription($dto->description);

        $company = $this->companyRepository->find($dto->companyId);
        if (!$company) {
            throw new NotFoundHttpException('Company not found');
        }
        
        $project->setCompany($company);

        $this->em->persist($project);
        $this->em->flush();

        return $project;
    }

    public function update(Project $project, ProjectRequest $dto): Project
    {
        $project->setName($dto->name);
        $project->setDescription($dto->description);

        $company = $this->companyRepository->find($dto->companyId);
        if (!$company) {
            throw new NotFoundHttpException('Company not found');
        }
        
        $project->setCompany($company);

        $this->em->flush();

        return $project;
    }

    public function delete(Project $project): void
    {
        $this->em->remove($project);
        $this->em->flush();
    }
}
