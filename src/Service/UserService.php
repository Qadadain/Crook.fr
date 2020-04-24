<?php

namespace App\Service;

use App\Model\UserManager;

class UserService
{
    const PSEUDO_MAX_LENGHT = 50;
    const EMAIL_MAX_LENGHT = 250;
    const PASSWORD_MIN_LENGHT = 8;

    public function validateFormUser(array $post)
    {
        $errors = [];
        if (empty($post['pseudo']) || strlen($post['pseudo']) > self::PSEUDO_MAX_LENGHT) {
            $errors[] = 'Votre pseudo doit faire entre 5 et 50 caractères';
        }
        if (empty($post['email']) || strlen($post['email']) > self::EMAIL_MAX_LENGHT) {
            $errors[] = 'Votre email doit faire entre 5 et 250 caractères';
        }
        if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Votre email n\'est pas valide ! ';
        }
        if (empty($post['emailRepeat'])) {
            $errors[] = 'La confirmation de l\'email est vide';
        }
        if ($post['emailRepeat'] !== $post['email']) {
            $errors[] = 'L\'email ne correspond pas';
        }
        if (empty($post['password']) || strlen($post['password']) < self::PASSWORD_MIN_LENGHT) {
            $errors[] = 'Votre mot de passe doit faire minimum 8 caractères';
        }
        if (empty($post['passwordRepeat'])) {
            $errors[] = 'La confirmation du mot de passe est vide';
        }
        if ($post['passwordRepeat'] !== $post['password']) {
            $errors[] = 'Le mot de passe ne correspond pas';
        }
        if (empty($errors)) {
            $validTest = $this->insertIntoUser($post);
        } else {
            $validTest = $errors;
        }
        return $validTest;
    }
    public function insertIntoUser(array $post)
    {
        $userManager = new UserManager();
        $user = $userManager->getUserbyEmail($post['email']);
        if ($user === false) {
            $addUser = new UserManager();
            try {
                $userManager = $addUser->addNewUser($post);
            } catch (\Exception $e) {
                $userManager = $e;
            }
            return $userManager;
        }
    }
}
