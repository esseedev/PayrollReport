<?php

namespace App\Controller;

use App\Command\CreateDepartmentCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class DepartmentController extends AbstractController
{
    public function __construct
    (
        private MessageBusInterface $commandBus
    ) { }
    
    #[Route('/department', name: 'department', methods: ['POST'])]
    public function createDepartment(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);
        
        $command = new CreateDepartmentCommand(
            name: $data['name'],
            isPercentageBased:  $data['isPercentageBased'],
            supplementPercentage: $data['supplementPercentage'],
        );
        
        $this->commandBus->dispatch($command);
        
        return new JsonResponse(['message' => 'Department created successfully'], Response::HTTP_CREATED);
    }

}