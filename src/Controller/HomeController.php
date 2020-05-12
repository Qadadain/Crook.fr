<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\CardManager;
use App\Model\FavoriteManager;
use App\Model\SheetManager;
use App\Service\SheetService;
use Michelf\MarkdownExtra;

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
    public function index()
    {
        $cardManager = new CardManager();
        $sheets = $cardManager->getCardPicture();
        $sheets = SheetService::convertIntoMarkDown($sheets);
        return $this->twig->render('Home/index.html.twig', [
            'sheets' => $sheets,
        ]);
    }

    public function about()
    {
        return $this->twig->render('Home/about.html.twig');
    }

    public function search()
    {

        $sheetManager = new SheetManager();
        $sheets = $sheetManager->getSheetByTitle($_GET['search']);

        return $this->twig->render('Home/search.html.twig', [
            'sheets' => $sheets,
        ]);
    }

    public function error(int $error)
    {
        return $this->twig->render('Home/error.html.twig', ['error' => $error]);
    }
}
