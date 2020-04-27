<?php

namespace App\Model;

class SheetManager extends AbstractManager
{
    const TABLE = 'sheet';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function addNewSheet(array $post, ?string $language): string
    {
        $return = 'Une erreur c\'est produite lors de l\'ajout';
        $sql = 'INSERT INTO sheet (title, description, content, created_at, popularity, user_id, language_id) 
                VALUES (:title, :description, :content, :created_at, :popularity, :user_id, :language_id)';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':title', $post['title']);
        $statement->bindValue(':description', $post['description']);
        $statement->bindValue(':content', $post['content']);
        $statement->bindValue(':created_at', date('Y-m-d H:i:s'));
        $statement->bindValue(':popularity', 0);
        $statement->bindValue(':user_id', 1); // TODO Need modify when login are avaible
        $statement->bindValue(':language_id', $language ? $language : $post['language']);
        if ($statement->execute()){
            $return = 'Votre sheet est bien enregistrée';
        }
        return $return;
    }

    public function getSheetForAdmin(string $page = null): array
    {
        $sql = 'SELECT s.id, s.title, s.created_at, s.popularity, s.updated_at, u.pseudo, l.name
            FROM sheet s 
            JOIN user u ON s.user_id = u.id
            JOIN language l ON s.language_id = l.id
            ORDER BY s.id';
        if ($page === 'home') {
            $sql .= ' DESC Limit 10';
        }
        $statement = $this->pdo->query($sql);
        return $statement->fetchAll();
    }
}
