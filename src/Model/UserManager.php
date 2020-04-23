<?php

namespace App\Model;

use Nette\Utils\DateTime;

class UserManager extends AbstractManager
{
    const TABLE = 'user';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getEmailByEmail(string $email)
    {
        $sql = 'SELECT email FROM user WHERE email = :email';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
    public function addNewUser(array $user)
    {
        $sql = "INSERT INTO " . self::TABLE . " (`pseudo`,`email`,`password`,`role_user`,`create_at`)
                VALUES (:pseudo,:email,:password,:role,:create_at)";
        $date = new DateTime();
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':pseudo', $user['pseudo'] ,\PDO::PARAM_STR);
        $statement->bindValue(':email', $user['email'] ,\PDO::PARAM_STR);
        $statement->bindValue(':password',password_hash($user['password'], PASSWORD_DEFAULT) ,\PDO::PARAM_STR);
        $statement->bindValue(':role', 'ROLE_USER',\PDO::PARAM_STR);
        $statement->bindValue(':create_at', $date,\PDO::PARAM_STR);
        if ( $statement->execute()){
            $isSignIn = true;
        }else {
            $isSignIn = false;
        }
       return $isSignIn;
    }
}
