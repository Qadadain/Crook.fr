<?php

namespace App\Controller;

use App\Model\FavoriteManager;
use App\Service\UserService;
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
            $userData = $userManager->getUserByEmail($_POST['email']);
            if (!is_array($userData)) {
                $error = 'Vous n\'êtes pas inscrit !';
                return $this->twig->render('User/user.html.twig', [
                    'error' => $error,
                ]);
            }
            if (password_verify($_POST['password'], $userData['password'])) {
                $_SESSION['id'] = $userData['id'];
                $_SESSION['email'] = $userData['email'];
                $_SESSION['pseudo'] = $userData['pseudo'];
                $_SESSION['role_user'] = $userData['role_user'];
                header('Location: /');
            } else {
                header('Location: /user/signin');
            }
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: /");
    }

    public function register()
    {
        $messages =[];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userService = new UserService();
                $messages = $userService->validateFormUser($_POST);
        }
        return $this->twig->render('User/user.html.twig', [
            'errors'=>$messages,
            'post'=>$_POST,
        ]);
    }

    public function favorite()
    {
        $favoriteManager = new FavoriteManager();
        $sheets = $favoriteManager->selectFavorite();
        return $this->twig->render('User/favorite.html.twig', [
           'sheets' => $sheets
        ]);
    }
}
