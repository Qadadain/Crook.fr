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
        $sheets = $sheetManager->getSheetForAdmin(self::PAGE);

        $userManager = new UserManager();
        $users = $userManager->getUserForAdmin(self::PAGE);

        $languageManager = new LanguageManager();
        $languages = $languageManager->getLanguageForAdmin(self::PAGE);

        return $this->twig->render('Admin/home.html.twig', [
            'sheets' => $sheets,
            'users' => $users,
            'languages' => $languages,
        ]);
    }

    public function allLanguage()
    {
        $languageManager = new LanguageManager();
        $language = $languageManager->getLanguageForAdmin(self::PAGE);
        $limit = '10';
        return $this->twig->render('Admin/language.html.twig', [
            'languages' => $language,
            'limit' => $limit,
        ]);
    }

    public function changeLanguage($limit)
    {
        $languageManager = new LanguageManager();
        $language = $languageManager->ajaxLanguage($limit);
        $count = count($language);
        return $this->twig->render('Admin/ajax/ajaxLanguage.html.twig', [
            'languages' => $language,
            'lengthTable' => $count,
        ]);
    }
    
    public function allsheet()
    {
        $sheetManager = new SheetManager();
        $sheets = $sheetManager->getAllSheetForAdmin(self::PAGE);

        return $this->twig->render('Admin/allsheet.html.twig', [
            'sheets' => $sheets,
        ]);
    }

    public function allUser()
    {
        $userManager = new UserManager();
        $users = $userManager->getUserForAdmin(self::PAGE);
        return $this->twig->render('Admin/allUser.html.twig', [
            'users' => $users,
        ]);
    }

    public function editUser()
    {
        $userManager = new UserManager();
        $users = $userManager->getUserForAdmin(self::PAGE);
        return $this->twig->render('Admin/editUser.html.twig', [
            'users' => $users,
        ]);
    }
}
