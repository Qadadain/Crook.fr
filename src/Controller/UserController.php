<?php

namespace App\Controller;

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

    public function register()
    {
        return 'toto';
    }
}
