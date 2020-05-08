<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\CardManager;
use App\Model\SheetManager;
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
        foreach ($sheets as $key => $sheet) {
            $markdown = MarkdownExtra::defaultTransform($sheet['content']);
            $sheets[$key]['content'] = $markdown;
        }
        return $this->twig->render('Home/index.html.twig', [
            'sheets'=>$sheets,
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
            'sheets'=>$sheets,
        ]);
    }
}
