<?php

namespace App\Service;

use App\Model\LanguageManager;
use App\Model\UserManager;

class AdminService
{
    const MAX_LENGHT_NAME = 100;
    const MAX_LENGHT_COLOR = 10;
    const ARRAY_VALUE_ISVALID = ['1', '0'];
    const PSEUDO_MAX_LENGHT = 50;
    const EMAIL_MAX_LENGHT = 250;
    const EMAIL_IN_BDD = 0;
    const ROLE_USER = ['ROLE_USER', 'ROLE_ADMIN'];

    public function languageForm(array $post): array
    {
        $errors = [];
        if ($post['name'] > self::MAX_LENGHT_NAME) {
            $errors[] = 'Votre nom doit etre inférieur à 100 caractères';
        }
        if ($post['color'] > self::MAX_LENGHT_COLOR) {
            $errors[] = 'Votre couleur doit etre inférieur à 10 caractères';
        }
        if (!preg_match('/^#/', $post['color'])) {
            $errors[] = 'Votre couleur doit être en hexadecimal';
        }
        if (!in_array($post['isValid'], self::ARRAY_VALUE_ISVALID)) {
            $errors[] = 'Veuillez choisir si vous certifiez le langage';
        }
        return $errors;
    }

    public function userForm(array $post): array
    {
        $errors = [];
        if (empty($post['pseudo']) || strlen($post['pseudo']) > self::PSEUDO_MAX_LENGHT) {
            $errors[] = 'Votre pseudo doit faire entre 5 et 50 caractères';
        }
        if (empty($post['email']) || strlen($post['email']) > self::EMAIL_MAX_LENGHT) {
            $errors[] = 'Votre email doit faire entre 5 et 250 caractères';
        }
        if (empty($post['role']) || !in_array($post['role'], self::ROLE_USER)) {
            $errors[] = 'Vous devez choisir entre utilisateur ou administrateur';
        }
        return $errors;
    }

    public function editLanguage($post): void
    {
        $languageManager = new LanguageManager();
        $languageManager->editLanguage($post);
    }

    public function editUser($post): bool
    {
        $languageManager = new UserManager();
        return $languageManager->editUser($post);
    }
}
