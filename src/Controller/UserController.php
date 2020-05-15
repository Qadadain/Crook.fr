<?php

namespace App\Controller;

use App\Model\FavoriteManager;
use App\Service\SheetService;
use App\Service\UserService;
use App\Model\UserManager;
use Michelf\MarkdownExtra;

class UserController extends AbstractController
{
    public function signIn(): string
    {
        return $this->twig->render('User/user.html.twig', [
        ]);
    }

    public function login(): string
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
                exit;
            } else {
                $error = 'Mauvais mot de passe ou adresse email';
                return $this->twig->render('User/user.html.twig', [
                    'error' => $error,
                ]);
            }
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: /");
    }

    public function register(): string
    {
        $messages = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userService = new UserService();
            $messages = $userService->validateFormUser($_POST);
        }
        return $this->twig->render('User/user.html.twig', [
            'errors'=>$messages,
            'post'=>$_POST,
        ]);
    }

    public function favorite(): string
    {
        $favoriteManager = new FavoriteManager();
        $sheets = $favoriteManager->selectFavorite();
        $sheets = SheetService::convertIntoMarkDown($sheets);
        return $this->twig->render('User/favorite.html.twig', [
           'sheets' => $sheets
        ]);
    }
}
