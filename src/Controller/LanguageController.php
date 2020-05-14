<?php
namespace App\Controller;

use App\Model\LanguageManager;
use App\Service\SheetService;

class LanguageController extends AbstractController
{
    public function list(): string
    {
        $languageManager = new LanguageManager();
        $languages = $languageManager->selectAllValid();

        return $this->twig->render('Languages/languages.html.twig', [
                'languages' => $languages
        ]);
    }

    public function sheets(int $id): string
    {
        $languageManager = new LanguageManager();
        $sheets = $languageManager->getSheetByLanguage($id);
        $sheets = SheetService::convertIntoMarkDown($sheets);

        return $this->twig->render('Languages/sheets.html.twig', [
            'sheets' => $sheets,

        ]);
    }

    public function noValid(): string
    {
        $languageManager = new LanguageManager();
        $sheets = $languageManager->getNoValidLanguage();
        $sheets = SheetService::convertIntoMarkDown($sheets);

        return $this->twig->render('Languages/sheets.html.twig', [
            'sheets' => $sheets,

        ]);
    }
}
