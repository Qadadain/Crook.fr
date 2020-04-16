<?php


namespace App\Controller;

use App\Model\FormManager;

class FormController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        $formManager = new FormManager();
        $languages = $formManager->getAllByName();
        return $this->twig->render('Form/form.html.twig', [
            'languages' => $languages,
        ]);
    }
}
