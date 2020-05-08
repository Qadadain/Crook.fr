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
    const NEW_LANGUAGE_MAX_LENGHT = 100;

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
            $errors[] = 'Votre contenu doit faire plus de 5 caractères';
        }
        if (isset($post['newLanguage']) && strlen($post['newLanguage']) > self::NEW_LANGUAGE_MAX_LENGHT) {
            $errors[] = 'Votre langage ne doit pas faire plus de 100 caractères';
        }
        if (!$this->checkLanguage($post['newLanguage']) && empty($post['language'])) {
            $errors[] = 'Votre language existe déjà';
        }
        return $errors;
    }

    public function insertIntoSheet(array $post)
    {
        $newLanguage = null;
        if (isset($post['newLanguage']) && empty($post['language'])) {
            $addLanguage = new LanguageManager();
            $newLanguage = $addLanguage->addNewLanguage($post['newLanguage']);
        }
        $sheetManager = new SheetManager();
        return $sheetManager->addNewSheet($post, $newLanguage);
    }

    public function checkLanguage(string $name)
    {
        $result = true;
        $languageManager = new LanguageManager();
        $language = $languageManager->checkLanguage($name);
        if (count($language) > 0) {
            $result = false;
        }
        return $result;
    }
}
