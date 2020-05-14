<?php

namespace App\Service;

use App\Model\FavoriteManager;

class FavoriteService
{
    public function checkFavorite(array $post)
    {
        $result = false;
        $favoriteManager = new FavoriteManager();
        $isLiked = $favoriteManager->selectWithId($post);
        if (!$isLiked) {
            $favoriteManager->addFavorite($post);
            $result = true;
        } else {
            $favoriteManager->deleteFavorite($post);
            $result = false;
        }
        return $result;
    }
}
