<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\SheetManager;
use App\Service\SheetService;

class HomeController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(): string
    {
        $sheetManager = new SheetManager();
        $sheets = $sheetManager->getCardPicture();
        $sheets = SheetService::convertIntoMarkDown($sheets);
        return $this->twig->render('Home/index.html.twig', [
            'sheets' => $sheets,
        ]);
    }

    public function about(): string
    {
        return $this->twig->render('Home/about.html.twig');
    }

    public function search(): string
    {

        $sheetManager = new SheetManager();
        $sheets = $sheetManager->getSheetByTitle($_GET['search']);

        return $this->twig->render('Home/search.html.twig', [
            'sheets' => $sheets,
        ]);
    }

    public function error(int $error): string
    {
        return $this->twig->render('Home/error.html.twig', ['error' => $error]);
    }
}
