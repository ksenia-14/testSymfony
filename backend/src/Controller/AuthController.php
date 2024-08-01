<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class AuthController extends AbstractController 
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/api/auth/', methods: ['POST'])]
    public function authentification(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $params = json_decode($request->getContent());

        $user = $this->userRepository->getUserByLogin($params->login);
        if ($user && $user->getPassword() === $params->password) {
            $data = $serializer->serialize(["success"=> true, 'token' => "some_token"], JsonEncoder::FORMAT);
        } else {
            $data = $serializer->serialize(['success' => false, "message" => "some error text"], JsonEncoder::FORMAT);
        }

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/api/register/', methods: ['POST'])]
    public function registration(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $params = json_decode($request->getContent());

        $user = new User();
        $user->setLogin($params->login);
        $user->setPassword($params->password);

        $this->userRepository->addNewUser($user);

        $data = $serializer->serialize(["success"=> true, 'token' => "some_token"], JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

}