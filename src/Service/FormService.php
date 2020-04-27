<?php

namespace App\Service;

use App\Model\LanguageManager;
use App\Model\SheetManager;

class FormService
{
    const TITLE_LENGHT = 80;
    const DESCRIPTION_MIN_LENGHT = 5;
    const DESCRIPTION_MAX_LENGHT = 250;
    const CONTENT_MIN_LENGHT = 5;

    public function validateForm(array $post)
    {
        $errors = [];
        if (empty($post['title']) || strlen($post['title']) > self::TITLE_LENGHT) {
            $errors[] = 'Votre titre doit faire entre 5 et 80 caractères';
        }
        if (empty($post['description']) || strlen($post['description']) < self::DESCRIPTION_MIN_LENGHT
            || strlen($post['description']) > self::DESCRIPTION_MAX_LENGHT) {
            $errors[] = 'Votre description doit faire entre 5 et 250 caractères';
        }
        if (empty($post['content']) || strlen($post['content']) < self::CONTENT_MIN_LENGHT) {
            $errors[] = 'Votre contenue dois faire plus de 5 caractères';
        }
        if (empty($errors)) {
            $return = $this->insertIntoSheet($post);
        } else {
            $return = $errors;
        }
        return $return;
    }

    public function insertIntoSheet(array $post)
    {
        $languageManager = new LanguageManager();
        $language = $languageManager->selectOneById($post['language']);
        $newLanguage = null;
        if (count($language) === 0) {
            $addLanguage = new LanguageManager();
            $newLanguage = $addLanguage->addNewLanguage($post['language']);
        }
        $sheetManager = new SheetManager();
        return $sheetManager->addNewSheet($post, $newLanguage);
    }
}
