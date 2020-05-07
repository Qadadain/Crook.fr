<?php

namespace App\Controller;

use App\Model\SheetManager;
use App\Model\UserManager;
use App\Model\LanguageManager;
use App\Service\AdminService;

class AdminController extends AbstractController
{
    const LIMIT = 10;

    public function home(): string
    {
        $sheetManager = new SheetManager();
        $sheets = $sheetManager->selectForAdmin();

        $userManager = new UserManager();
        $users = $userManager->selectForAdmin();

        $languageManager = new LanguageManager();
        $languages = $languageManager->selectForAdmin();

        return $this->twig->render('Admin/home.html.twig', [
            'sheets' => $sheets,
            'users' => $users,
            'languages' => $languages,
        ]);
    }

    public function allLanguage(): string
    {
        $languageManager = new LanguageManager();
        $language = $languageManager->selectForAdmin();
        $limit = self::LIMIT;
        return $this->twig->render('Admin/allLanguage.html.twig', [
            'languages' => $language,
            'limit' => $limit,
        ]);
    }
    
    public function allsheet(): string
    {
        $sheetManager = new SheetManager();
        $sheets = $sheetManager->getTenSheet();
        $limit = self::LIMIT;
        return $this->twig->render('Admin/allsheet.html.twig', [
            'sheets' => $sheets,
            'limit' => $limit,
        ]);
    }

    public function allUser(): string
    {
        $userManager = new UserManager();
        $users = $userManager->selectForAdmin();
        $limit = self::LIMIT;
        return $this->twig->render('Admin/allUser.html.twig', [
            'users' => $users,
            'limit' => $limit,
        ]);
    }

    public function editLanguage(int $id): string
    {
        $errors = [];
        if (!empty($_POST)) {
            $adminService = new AdminService();
            $errors = $adminService->languageForm($_POST);
            if (empty($errors)) {
                $adminService->editLanguage($_POST);
            }
        }
        $languageManager = new LanguageManager();
        $language = $languageManager->selectOneById($id);
        return $this->twig->render('Admin/editLanguage.html.twig', [
            'language' => $language,
            'errors' => $errors,
        ]);
    }

    public function editUser(int $id): string
    {
        $errors = [];
        $success = false;
        if (!empty($_POST)) {
            $adminService = new AdminService();
            $errors = $adminService->userForm($_POST);
            if (empty($errors)) {
                $success = $adminService->editUser($_POST);
            }
        }
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);
        return $this->twig->render('Admin/editUser.html.twig', [
            'user' => $user,
            'errors' => $errors,
            'success' => $success,
        ]);
    }

    public function editSheet(int $id): string
    {
        $errors = [];
        $success = false;
        if (!empty($_POST)) {
            $adminService = new AdminService();
            $errors = $adminService->sheetForm($_POST);
            if (empty($errors)) {
                $success = $adminService->editSheet($_POST);
            }
        }
        $sheetManager = new SheetManager();
        $sheet = $sheetManager->getSheetById($id);
        $languageManager = new LanguageManager();
        $languages = $languageManager->selectAll();
        $userManager = new UserManager();
        $users = $userManager->selectAll();
        return $this->twig->render('Admin/editSheet.html.twig', [
            'sheet' => $sheet,
            'languages' => $languages,
            'users' => $users,
            'errors' => $errors,
            'success' => $success,
        ]);
    }
}
