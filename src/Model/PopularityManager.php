<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class PopularityManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'vote';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getPopularityById(array $post)
    {
        $sql = 'SELECT * FROM popularity WHERE user_id = :user_id AND sheet_id = :sheet_id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $post['userId']);
        $statement->bindValue(':sheet_id', $post['sheetId']);
        $statement->execute();
        return $statement->fetch();
    }

    public function insertPopularity(array $post)
    {
        $sql = 'INSERT INTO popularity (user_id, sheet_id, vote) 
                VALUES (:user_id, :sheet_id, :vote)';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $post['userId']);
        $statement->bindValue(':sheet_id', $post['sheetId']);
        $statement->bindValue(':vote', $post['value']);
        $statement->execute();
    }

    public function updatePopularity(string $value, string $id)
    {
        $sql = 'UPDATE popularity
                SET vote = :vote
                WHERE id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':vote', $value);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }

    public function sumPopularity(string $sheetId): array
    {
        $sql = 'SELECT SUM(vote) total FROM popularity WHERE sheet_id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $sheetId);
        $statement->execute();
        return $statement->fetch();
    }
}
