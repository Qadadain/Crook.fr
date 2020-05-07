<?php

namespace App\Model;

use \Exception;
use \DateTime;

class UserManager extends AbstractManager
{
    const TABLE = 'user';
    const MAXLIMIT = 10;

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getUserByEmail(string $email)
    {
        $sql = 'SELECT * FROM user WHERE email = :email';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public function addNewUser(array $user)
    {
        $sql = "INSERT INTO " . self::TABLE . " (`pseudo`,`email`,`password`,`role_user`,`create_at`)
                VALUES (:pseudo,:email,:password,:role,NOW())";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':pseudo', $user['pseudo'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue(':password', password_hash($user['password'], PASSWORD_DEFAULT), \PDO::PARAM_STR);
        $statement->bindValue(':role', 'ROLE_USER', \PDO::PARAM_STR);
        if ($statement->execute()) {
            $isSignIn = $this->pdo->lastInsertId();
        } else {
            throw new Exception('Erreur pendant l\'ajout d\'un nouveau utilisateur');
        }
        return $isSignIn;
    }

    public function ajaxUser(int $limit): array
    {
        $maxLimit = $limit + self::MAXLIMIT;
        $sql = 'SELECT u.id, u.pseudo, u.email, u.create_at, u.update_at, u.role_user  
                FROM user u 
                ORDER BY u.id 
                LIMIT ' . $limit . ', ' . $maxLimit;
        $statement = $this->pdo->query($sql);

        return $statement->fetchAll();
    }

    public function editUser(array $post): bool
    {
        $sql = 'UPDATE '. self::TABLE .' 
            SET pseudo = :pseudo, email = :email, role_user = :role, update_at = NOW()
            WHERE id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':pseudo', $post['pseudo']);
        $statement->bindValue(':email', $post['email']);
        $statement->bindValue(':role', $post['role']);
        $statement->bindValue(':id', $post['id']);
        return $statement->execute();
    }
}
