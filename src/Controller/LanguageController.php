<?php
namespace App\Controller;

use App\Model\LanguageManager;
use App\Service\SheetService;
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
        $sheets = SheetService::convertIntoMarkDown($sheets);

        return $this->twig->render('Languages/sheets.html.twig', [
            'sheets' => $sheets,

        ]);
    }
}
