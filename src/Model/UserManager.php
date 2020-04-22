<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    const TABLE = 'sheet';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getEmailByEmail()
    {
        $sql = 'SELECT email FROM user WHERE email = :email';
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetch();
    }
}
