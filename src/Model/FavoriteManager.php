<?php

namespace App\Model;

class FavoriteManager extends AbstractManager
{
    const TABLE = 'favorite';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectWithId(array $post)
    {
        $sql = 'SELECT * FROM favorite WHERE user_id = :user_id AND sheet_id = :sheet_id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $post['userId']);
        $statement->bindValue(':sheet_id', $post['sheetId']);
        $statement->execute();
        return $statement->fetch();
    }

    public function selectFavorite(): array
    {
        $sql = 'SELECT s.id, s.title, s.description, s.content, 
                    l.name, l.color, l.image, s.created_at,
                    (SELECT SUM(p.vote) FROM popularity p WHERE p.sheet_id = s.id) popularity';
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
                 JOIN favorite f
                 ON f.sheet_id = s.id
                 WHERE f.user_id = '. $_SESSION['id'];
        $statement = $this->pdo->prepare($sql);

        $statement->execute();
        return $statement->fetchAll();
    }

    public function addFavorite(array $post): void
    {
        $sql = 'INSERT INTO favorite (user_id, sheet_id) VALUES (:user_id, :sheet_id)';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', (int)$post['userId']);
        $statement->bindValue(':sheet_id', (int)$post['sheetId']);
        $statement->execute();
    }

    public function deleteFavorite(array $post): void
    {
        $sql = 'DELETE FROM favorite WHERE user_id = :user_id AND sheet_id = :sheet_id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', (int)$post['userId']);
        $statement->bindValue(':sheet_id', (int)$post['sheetId']);
        $statement->execute();
    }
}
