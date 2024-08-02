<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class FierceKangarooController extends AbstractController
{
    #[Route('/fierce/kangaroo', name: 'app_fierce_kangaroo')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/FierceKangarooController.php',
        ]);
    }
}
