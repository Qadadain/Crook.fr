<?php
namespace App\Controller;

use App\Model\LanguageManager;
use Michelf\MarkdownExtra;

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

    public function sheets(int $id)
    {
        $languageManager = new LanguageManager();
        $sheets = $languageManager->getSheetByLanguage($id);
        foreach ($sheets as $key => $sheet) {
            $markdown = MarkdownExtra::defaultTransform($sheet['content']);
            $sheets[$key]['content'] = $markdown;
        }

        return $this->twig->render('Languages/sheets.html.twig', [
            'sheets' => $sheets,

        ]);
    }
}
