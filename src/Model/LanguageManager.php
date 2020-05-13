<?php

namespace App\Model;

class LanguageManager extends AbstractManager
{
    const TABLE = 'language';
    const MAXLIMIT = 10;
    const BASE_COLOR = '#161630';
    const BASE_LOGO = '/assets/images/Crook_.png';
    const BASE_IS_VALID = 0;
    const IS_VALID = 1;

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getLanguageName(): array
    {
        $statement = $this->pdo->query('SELECT name, id FROM language');
        return $statement->fetchAll();
    }

    public function selectAllValid(): array
    {
        $sql = 'SELECT * from language WHERE is_valid = 1';
        $statement = $this->pdo->query($sql);
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
                 WHERE l.id = :id
                 AND l.is_valid = ' . self::IS_VALID .'
                 ORDER BY s.created_at DESC';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getNoValidLanguage(): array
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
                 WHERE l.is_valid = ' . self::BASE_IS_VALID . '
                 ORDER BY s.created_at DESC';
        $statement = $this->pdo->query($sql);
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
