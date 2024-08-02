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
            $response = $this->json(["success"=> true, 'token' => "some_token"]);
        } else {
            $response = $this->json(['success' => false, "message" => "Неверный логин или пароль"]);
        }

        return $response;
    }

    #[Route('/api/register/', methods: ['POST'])]
    public function registration(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $params = json_decode($request->getContent());

        if ($this->isCorrectEmail($params->login) || $this->isCorrectPhoneNumber($params->login)) {
            $user = new User();
            $user->setLogin($params->login);
            $user->setPassword($params->password);
    
            $this->userRepository->addNewUser($user);
    
            $response = $this->json(["success"=> true, 'token' => "some_token"]);
        } else{
            $response = $this->json(["success" => false, "message" => "Логин должен быть почтовым адресом или номером телефона"]);
        }

        return $response;
    }

    private function isCorrectEmail($email) {
        $pattern = "#^[A-Za-z0-9.-_]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$#";
        return preg_match($pattern, $email) == true;
    }
    
    private function isCorrectPhoneNumber($phone_number) {
        $pattern = "#^[+]?[0-9 -]{10,}$#";
        if (preg_match($pattern, $phone_number)) {
            $phone_number = preg_replace("#[^0-9]#", '', $phone_number);
            if (strlen($phone_number) >= 10) {
                return true;
            }
        }
        return false;
    }
}