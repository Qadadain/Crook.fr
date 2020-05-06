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
        $sql = 'SELECT s.id, s.title, s.created_at, popularity, s.updated_at, u.pseudo, l.name
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
        $statement->bindValue(':search','%' . $searchTitle . '%');
        $statement->execute();
        return $statement->fetchAll();
    }
}
