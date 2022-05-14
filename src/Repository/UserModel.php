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
    private function getUserByEmail(string $email): ?array
    {
        $sql = 'SELECT * FROM User WHERE email = ?';

        return $this->db->getOneResult($sql, [$email]);
    }

    /**
     * On vérifie les identifiants de connexion de l'utilisateur
     * Si les identifiants sont corrects, on retourne l'utilisateur
     * False si l'email n'existe pas ou le mot de passe est incorrect
     */
    public function checkUserInformations(string $email, string $password)
    {
        // On va chercher l'utilisateur à partir de l'email
        $user = $this->getUserByEmail($email);

        // Si l'utilisateur existe 
        if ($user) {
            // Si le mot de passe est correct
            if (password_verify($password, $user['password'])) {

                // Tout est OK on peut retourner l'utilisateur
                return $user;
            }
        }

        // Si on arrive ici c'est qu'il y a un soucis soit avec l'email, soit avec le mot de passe
        return false;
    }
}
