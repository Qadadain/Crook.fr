<?php

namespace App\Controller;
use App\Service\UserService;

class UserController extends AbstractController
{
    public function signIn()
    {
        return $this->twig->render('User/user.html.twig', [
        ]);
    }

    public function login()
    {
        return 'toto';
    }

    public function register(array $post)
    {
        $messages =[];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userService = new UserService();
                $messages = $userService->validateFormUser($_POST);
        }
        return $this->twig->render('User/user.html.twig', [
            'errors'=>$messages,
        ]);
    }

}
