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

    public function selectFavorite()
    {
        $sql = 'SELECT s.id, title, description, content, 
                    l.name, color, image, created_at, f.user_id
                FROM favorite f
                INNER JOIN sheet s
                ON f.sheet_id = s.id
                INNER JOIN user u
                ON f.user_id = u.id
                INNER JOIN language l
                ON s.language_id = l.id
                WHERE f.user_id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $_SESSION['id']);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function addFavorite(array $post)
    {
        $sql = 'INSERT INTO favorite (user_id, sheet_id) VALUES (:user_id, :sheet_id)';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', (int)$post['userId']);
        $statement->bindValue(':sheet_id', (int)$post['sheetId']);
        $statement->execute();
    }

    public function deleteFavorite(array $post)
    {
        $sql = 'DELETE FROM favorite WHERE user_id = :user_id AND sheet_id = :sheet_id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', (int)$post['userId']);
        $statement->bindValue(':sheet_id', (int)$post['sheetId']);
        $statement->execute();
    }
}
