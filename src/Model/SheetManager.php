<?php

namespace App\Model;

class SheetManager extends AbstractManager
{
    const TABLE = 'sheet';
    const MAXLIMIT = 10;

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function addNewSheet(array $post, ?int $language): string
    {
        $return = 'Une erreur c\'est produite lors de l\'ajout';
        $sql = 'INSERT INTO sheet (title, description, content, created_at, user_id, language_id) 
                VALUES (:title, :description, :content, NOW(), :user_id, :language_id)';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':title', $post['title']);
        $statement->bindValue(':description', $post['description']);
        $statement->bindValue(':content', $post['content']);
        $statement->bindValue(':user_id', $_SESSION['id']);
        $statement->bindValue(':language_id', $language ? $language : $post['language']);

        if ($statement->execute()) {
            $return = 'Votre sheet est bien enregistrée';
        }
        return $return;
    }

    public function getTenSheet(): array
    {
        $sql = 'SELECT s.id, s.title, s.created_at, s.updated_at, u.pseudo, l.name
            FROM sheet s 
            JOIN user u ON s.user_id = u.id
            JOIN language l ON s.language_id = l.id
            ORDER BY s.id
            LIMIT 10';

        $statement = $this->pdo->query($sql);
        return $statement->fetchAll();
    }

    public function ajaxSheet(int $limit): array
    {
        $maxLimit = $limit + self::MAXLIMIT;
        $sql = 'SELECT * FROM sheet s ORDER BY s.id LIMIT ' . $limit . ', ' . $maxLimit;
        $statement = $this->pdo->query($sql);

        return $statement->fetchAll();
    }

    public function getSheetByTitle(string $searchTitle): array
    {
        $sql = 'SELECT *
            FROM sheet s 
            JOIN user u ON s.user_id = u.id
            JOIN language l ON s.language_id = l.id
            WHERE s.title 
            LIKE :search';

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':search', '%' . $searchTitle . '%');
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getSheetById(int $id): array
    {
        $sql = 'SELECT s.id, s.title, s.description, s.content, u.pseudo, u.id userId, l.id languageId, l.name
            FROM sheet s 
            JOIN user u ON s.user_id = u.id
            JOIN language l ON s.language_id = l.id
            WHERE s.id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch();
    }

    public function editSheet(array $post): bool
    {
        $sql = 'UPDATE '. self::TABLE .' 
            SET title = :title, description = :description, content = :content, 
                user_id = :author, language_id = :language, updated_at = NOW()
            WHERE id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':title', $post['title']);
        $statement->bindValue(':description', $post['description']);
        $statement->bindValue(':content', $post['content']);
        $statement->bindValue(':author', $post['author']);
        $statement->bindValue(':language', $post['language']);
        $statement->bindValue(':id', $post['id']);
        return $statement->execute();
    }

    public function getCardPicture(): array
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
                 ORDER BY s.created_at
                 DESC LIMIT 6';
        $statement = $this->pdo->query($sql);
        return $statement->fetchAll();
    }
}
