<?php
namespace App\Repository;
use PDOStatement;
use App\Framework\AbstractModel;

class UserModel extends AbstractModel
{
    /**
     * On ajoute un nouvel utilisateur/administrateur
     * @return PDOStatement
     */
    public function createNewUser(string $firstName,string $lastName,string $email,string $password):PDOStatement
    {
        $sql = 'INSERT INTO User (prenom, nom , email, password) value (?,?,?,?) ';
        return $this->db->prepareAndExecute($sql, [$firstName, $lastName, $email,$password]);
    }

    /**
     * Sélection d'un utilisateur à partir de son email
     */
    public function getUserByEmail(string $email): ?array
    {
        $sql = 'SELECT * FROM User WHERE email = ?';

        return $this->db->getOneResult($sql, [$email]);
    }

}
