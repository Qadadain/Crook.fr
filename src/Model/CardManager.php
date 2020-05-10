<?php

namespace App\Model;

class CardManager extends AbstractManager
{
    const TABLE = 'sheet';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    
    public function getCardPicture(): array
    {
        $sql = 'SELECT sheet.id, title, description, content, 
                    language.name, color, image, created_at, favorite.user_id 
                FROM sheet 
                JOIN language 
                ON sheet.language_id = language.id
                LEFT JOIN favorite
                ON sheet.id = favorite.sheet_id
                ORDER BY created_at 
                DESC LIMIT 6 ';
        $statement = $this->pdo->query($sql);
        return $statement->fetchAll();
    }
}
