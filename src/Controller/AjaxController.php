<?php

namespace App\Controller;

use App\Model\SheetManager;
use App\Model\UserManager;
use App\Model\LanguageManager;

class AjaxController extends AbstractController
{
    public function ajaxDeleteLanguage(): string
    {
        $languageManager = new LanguageManager();
        $languageManager->delete($_POST['id']);
        return json_encode('Le language a été supprimer');
    }

    public function ajaxDeleteUser(): string
    {
        $userManager = new UserManager();
        $userManager->delete($_POST['id']);
        return json_encode('L\'utilisateur a été supprimer');
    }

    public function ajaxDeleteSheet(): string
    {
        $sheetManager = new SheetManager();
        $sheetManager->delete($_POST['id']);
        return json_encode('Le sheet a été supprimer');
    }

    public function ajaxChangeSheet($limit): string
    {
        $sheetManager = new SheetManager();
        $sheet = $sheetManager->ajaxSheet($limit);
        $count = count($sheet);
        return $this->twig->render('Admin/ajax/ajaxSheet.html.twig', [
            'sheets' => $sheet,
            'lengthTable' => $count,
        ]);
    }

    public function ajaxChangeUser($limit): string
    {
        $userManager = new UserManager();
        $users = $userManager->ajaxUser($limit);
        $count = count($users);

        return $this->twig->render('Admin/ajax/ajaxUser.html.twig', [
            'users' => $users,
            'lengthTable' => $count,
        ]);
    }
    
    public function ajaxChangeLanguage($limit): string
    {
        $languageManager = new LanguageManager();
        $language = $languageManager->ajaxLanguage($limit);
        $count = count($language);
        return $this->twig->render('Admin/ajax/ajaxLanguage.html.twig', [
            'languages' => $language,
            'lengthTable' => $count,
        ]);
    }
}
