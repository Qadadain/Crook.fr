<?php


namespace App\Service;


use Michelf\MarkdownExtra;

class SheetService
{
static public function convertIntoMarkDown(array $sheets): array
{
    foreach ($sheets as $key => $sheet) {
        $markdown = MarkdownExtra::defaultTransform($sheet['content']);
        $sheets[$key]['content'] = $markdown;
    }
    return $sheets;
}
}