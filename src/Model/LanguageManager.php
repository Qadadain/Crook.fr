<?php

namespace App\Model;

class LanguageManager extends AbstractManager
{
    const TABLE = 'language';
    const MAXLIMIT = 10;

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getLanguageName(): array
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

    public function editLanguage(array $post): void
    {
        $sql = 'UPDATE '. self::TABLE .' 
            SET name = :name, color = :color, image = :image, update_at = NOW(), is_valid = :is_valid WHERE id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':name', $post['name']);
        $statement->bindValue(':color', $post['color']);
        $statement->bindValue(':image', $post['image']);
        $statement->bindValue(':is_valid', $post['isValid']) == '1' ? true : false;
        $statement->bindValue(':id', $post['id']);
        $statement->execute();
    }
 
    public function ajaxLanguage(int $limit): array
    {
        $maxLimit = $limit + self::MAXLIMIT;
        $sql = 'SELECT * FROM language l ORDER BY l.id LIMIT ' . $limit . ', ' . $maxLimit;
        $statement = $this->pdo->query($sql);
        return $statement->fetchAll();
    }
}
