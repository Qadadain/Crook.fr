<?php

namespace App\Service;

use App\Model\PopularityManager;

class PopularityService
{
    const EXPECTED_ERROR = 0;

    public static function checkData(array $post): bool
    {
        $errors = self::EXPECTED_ERROR;
        $result = false;
        if (empty($post['userId'])) {
            $errors++;
        }
        if (empty($_POST['sheetId'])) {
            $errors++;
        }
        if (empty($post['value'])) {
            $errors++;
        }
        if ($errors === self::EXPECTED_ERROR) {
            $result = true;
        }
        return $result;
    }
}
