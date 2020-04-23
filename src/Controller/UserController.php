<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function signIn()
    {
        return $this->twig->render('User/user.html.twig', [
        ]);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $userData = $userManager->getEmailByEmail($_POST['email']);

            if (!$userData) {
                header('Location: /user/signin');
                exit;
            }

            if (password_verify($_POST['email'], $userData['email'])) {
                $_SESSION['email'] = $userData['email'];
                $_SESSION['password'] = $userData['password'];
                header('Location: /');
            } else {
                header('Location: /');

                exit;
            }
        }
    }

    public function register()
    {
        return 'toto';
    }
}
