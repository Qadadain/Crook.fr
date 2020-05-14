<?php


namespace App\Controller;

use App\Model\LanguageManager;
use App\Service\FormService;

class SheetController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add(): string
    {

        if (!empty($_POST)) {
            $formService = new FormService();
            $errors = $formService->validateForm($_POST);
            if (empty($errors)) {
                $formService->insertIntoSheet($_POST);
                header('Location: /');
            }
        }
        $languageManager = new LanguageManager();
        $languages = $languageManager->getLanguageName();
        return $this->twig->render('Form/form.html.twig', [
            'languages' => $languages,
            'post' => $_POST,
            'errors' => isset($errors) ? $errors : null,
        ]);
    }
}
