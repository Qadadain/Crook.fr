<?php

namespace App\Controller;

use App\Model\SheetManager;
use App\Model\UserManager;
use App\Model\LanguageManager;

class AdminController extends AbstractController
{
    const PAGE = 'home';

    public function home()
    {
        $sheetManager = new SheetManager(self::PAGE);
        $sheet =$sheetManager->getSheetForAdmin(self::PAGE);

        $userManager = new UserManager(self::PAGE);
        $user = $userManager->getUserForAdmin();

        $languageManager = new LanguageManager(self::PAGE);
        $language = $languageManager->getUserForAdmin();
        return $this->twig->render('Admin/home.html.twig', [
            'sheet' => $sheet,
            'user' => $user,
            'language' => $language,
        ]);
    }
}