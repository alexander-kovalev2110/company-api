<?php

namespace App\Controller;

use App\Entity\Company;
use App\DTO\CompanyRequest;
use App\Service\CompanyService;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/companies')]
class CompanyController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function showAll(CompanyRepository $repo): JsonResponse
    {
        return $this->json($repo->findAll());
    }

    #[Route('/{id}', methods: ['GET'])]
    public function showById(Company $company): JsonResponse
    {
        return $this->json($company);
    }

    #[Route('', methods: ['POST'])]
    public function create(
        CompanyRequest $dto,
        CompanyService $service
    ): JsonResponse {

        $company = $service->create($dto);

        return $this->json($company, 201);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(
        Company $company,
        CompanyRequest $dto,
        CompanyService $service
    ): JsonResponse {

        $company = $service->update($company, $dto);

        return $this->json($company);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(
        Company $company,
        CompanyService $service
    ): JsonResponse {

        $service->delete($company);

        return $this->json(['status' => 'deleted']);
    }
}