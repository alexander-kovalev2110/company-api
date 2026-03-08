<?php

namespace App\Controller;

use App\Entity\Employee;
use App\DTO\EmployeeRequest;
use App\Service\EmployeeService;
use App\Repository\EmployeeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/employees')]
class EmployeeController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function showAll(EmployeeRepository $repo): JsonResponse
    {
        return $this->json($repo->findAll());
    }

    #[Route('/{id}', methods: ['GET'])]
    public function showById(Employee $employee): JsonResponse
    {
        return $this->json($employee);
    }

    #[Route('', methods: ['POST'])]
    public function create(
        EmployeeRequest $dto,
        EmployeeService $service
    ): JsonResponse {

        $employee = $service->create($dto);

        return $this->json($employee, 201);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(
        Employee $employee,
        EmployeeRequest $dto,
        EmployeeService $service
    ): JsonResponse {

        $employee = $service->update($employee, $dto);

        return $this->json($employee);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(
        Employee $employee,
        EmployeeService $service
    ): JsonResponse {

        $service->delete($employee);

        return $this->json(['status' => 'deleted']);
    }
}