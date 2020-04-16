<?php


namespace App\Model;

class FormManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'sheet';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getAllByName(): array
    {
        $statement = $this->pdo->query('SELECT name FROM language WHERE is_valid = 1');
        return $statement->fetchAll();
    }
}
