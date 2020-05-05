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
        $statement = $this->pdo->query("SELECT * FROM sheet INNER JOIN language WHERE sheet.language_id = language.id");
        return $statement->fetchAll();
    }
}
