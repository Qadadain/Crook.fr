<?php

namespace App\Service;

use App\Model\LanguageManager;

class AdminService
{
    const MAX_LENGHT_NAME = 100;
    const MAX_LENGHT_COLOR = 10;
    const ARRAY_VALUE_ISVALID = ['1', '0'];

    public function languageForm(array $post): array
    {
        $errors = [];
        if ($post['name'] > self::MAX_LENGHT_NAME) {
            $errors[] = 'Votre nom doit etre inférieur à 100 caracthères';
        }
        if ($post['color'] > self::MAX_LENGHT_COLOR) {
            $errors[] = 'Votre couleur doit etre inférieur à 10 caracthères';
        }
        if (!preg_match('/^#/', $post['color'])) {
            $errors[] = 'Votre couleur doit être en hexadecimal';
        }
        if (!in_array($post['isValid'], self::ARRAY_VALUE_ISVALID)) {
            $errors[] = 'Veuillez choisir si vous certifier le language';
        }
        return $errors;
    }

    public function editLanguage($post): void
    {
        $languageManager = new LanguageManager();
        $languageManager->editLanguage($post);
    }
}
