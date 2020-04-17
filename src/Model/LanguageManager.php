<?php

namespace App\Model;

class LanguageManager extends AbstractManager
{
    const TABLE = 'language';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getAllByName(): array
    {
        $statement = $this->pdo->query('SELECT name, id FROM language');
        return $statement->fetchAll();
    }

    public function addNewLanguage(string $language): string
    {
        $sql = 'INSERT INTO language (name, color, image, create_at) 
                VALUES (name = :name, color = :color, image = :image, create_at = :create_at)';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':name', $language);
        $statement->bindValue(':color', '#161630');
        $statement->bindValue(':image', 'logo');
        $statement->bindValue(':create_at', date('YY-MM-DD'));
        $statement->execute();
        return $this->pdo->lastInsertId();
    }
}
