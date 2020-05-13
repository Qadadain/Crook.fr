<?php

namespace App\Model;

class LanguageManager extends AbstractManager
{
    const TABLE = 'language';
    const MAXLIMIT = 10;
    const BASE_COLOR = '#161630';
    const BASE_LOGO = '/assets/image/Crook_.png';
    const BASE_IS_VALID = 0;

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getLanguageName(): array
    {
        $statement = $this->pdo->query('SELECT name, id FROM language');
        return $statement->fetchAll();
    }

    public function addNewLanguage(string $language): int
    {
        $sql = 'INSERT INTO ' . self::TABLE . ' (name, color, image, is_valid, create_at) 
                VALUES (:name, :color, :image, :is_valid, NOW())';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':name', $language);
        $statement->bindValue(':color', self::BASE_COLOR);
        $statement->bindValue(':image', self::BASE_LOGO);
        $statement->bindValue(':is_valid', self::BASE_IS_VALID);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function editLanguage(array $post): void
    {
        $sql = 'UPDATE '. self::TABLE .' 
            SET name = :name, color = :color, image = :image, update_at = NOW(), is_valid = :is_valid WHERE id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':name', $post['name']);
        $statement->bindValue(':color', $post['color']);
        $statement->bindValue(':image', $post['image']);
        $statement->bindValue(':is_valid', $post['isValid'] == '1' ? true : false);
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

    public function getSheetByLanguage(int $id): array
    {
        $sql = 'SELECT s.id, s.title, s.description, s.content, 
                s.created_at, u.pseudo, l.name, l.image, f.user_id 
            FROM sheet s 
            JOIN user u ON s.user_id = u.id
            JOIN language l ON s.language_id = l.id
            LEFT JOIN favorite f
            ON s.id = f.sheet_id
            WHERE l.id = :id;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function checkLanguage($name): array
    {
        $statement = $this->pdo->prepare('SELECT name from language WHERE name = :name');
        $statement->bindValue(':name', $name);
        $statement->execute();
        return $statement->fetchAll();
    }
}
