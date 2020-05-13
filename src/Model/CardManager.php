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
                    l.name, l.color, l.image, s.created_at';
        if (isset($_SESSION['id'])) {
            $sql .= ', (SELECT f.user_id 
                      FROM favorite f 
                      WHERE f.sheet_id = s.id 
                      AND f.user_id = ' . $_SESSION['id'] .') favoris,
                      (SELECT p.vote
                      FROM popularity p 
                      WHERE p.sheet_id = s.id 
                      AND p.user_id = '. $_SESSION['id'] . ') vote';
        }
        $sql .= ' FROM sheet s
                 JOIN language l
                 ON s.language_id = l.id
                 ORDER BY s.created_at
                 DESC LIMIT 6';
        $statement = $this->pdo->query($sql);
        return $statement->fetchAll();
    }
}
