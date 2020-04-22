<?php

namespace App\Service;

use App\Model\LanguageManager;
use App\Model\SheetManager;

class FormService
{
    public function validateForm(array $post)
    {
        $errors = [];
        if (empty($post['title']) || strlen($post['title']) > 80) {
            $errors[] = 'Votre titre doit faire entre 5 et 80 caractères';
        }
        if (empty($post['description']) || strlen($post['description']) < 1 || strlen($post['description']) > 250) {
            $errors[] = 'Votre description doit faire entre 5 et 250 caractères';
        }
        if (empty($post['content']) || strlen($post['content']) < 5) {
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
