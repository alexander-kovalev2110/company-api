<?php

namespace App\Controller;

use App\Entity\Project;
use App\DTO\ProjectRequest;
use App\Service\ProjectService;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/projects')]
class ProjectController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function showAll(ProjectRepository $repo): JsonResponse
    {
        return $this->json($repo->findAll());
    }

    #[Route('/{id}', methods: ['GET'])]
    public function showById(Project $project): JsonResponse
    {
        return $this->json($project);
    }

    #[Route('', methods: ['POST'])]
    public function create(
        ProjectRequest $dto,
        ProjectService $service
    ): JsonResponse {

        $project = $service->create($dto);

        return $this->json($project, 201);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(
        Project $project,
        ProjectRequest $dto,
        ProjectService $service
    ): JsonResponse {

        $project = $service->update($project, $dto);

        return $this->json($project);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(
        Project $project,
        ProjectService $service
    ): JsonResponse {

        $service->delete($project);

        return $this->json(['status' => 'deleted']);
    }
}
