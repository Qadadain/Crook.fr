<?php

namespace App\Controller;

use App\Model\SheetManager;
use App\Model\UserManager;
use App\Model\LanguageManager;
use App\Service\AdminService;

class AdminController extends AbstractController
{
    const PAGE = 'home';

    public function home()
    {
        $sheetManager = new SheetManager();
        $sheets =$sheetManager->getSheetForAdmin(self::PAGE);

        $userManager = new UserManager();
        $users = $userManager->getUserForAdmin(self::PAGE);

        $languageManager = new LanguageManager();
        $languages = $languageManager->getUserForAdmin(self::PAGE);

        return $this->twig->render('Admin/home.html.twig', [
            'sheets' => $sheets,
            'users' => $users,
            'languages' => $languages,
        ]);
    }
}
