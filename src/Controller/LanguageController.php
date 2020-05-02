<?php
namespace App\Controller;

use App\Model\LanguageManager;

class LanguageController extends AbstractController
{
    public function list()
    {
        $languageManager = new LanguageManager();
        $languages = $languageManager->selectAll();

        return $this->twig->render('Languages/languages.html.twig', [
                'languages' => $languages
            ]);
    }
}
