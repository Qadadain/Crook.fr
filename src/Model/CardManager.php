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
        $sql = 'SELECT s.id, s.title, s.description, s.content, 
	                   l.name, l.color, l.image, s.created_at, f.user_id,
	                   (SELECT SUM(p.vote) FROM popularity p WHERE p.sheet_id = s.id GROUP BY p.sheet_id) popularity
                FROM sheet s
                JOIN language l
                ON s.language_id = l.id
                LEFT JOIN favorite f
                ON s.id = f.sheet_id
                ORDER BY s.created_at 
                DESC LIMIT 6';
        $statement = $this->pdo->query($sql);
        return $statement->fetchAll();
    }
}
