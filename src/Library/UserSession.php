<?php
namespace App\Library;

class UserSession 
{
    public function __construct()
    {
        //Démarrage d'une session si celle ci n'existe pas
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }

        /**
     * Enregistre les données de l'utilisateur en session
     */
    function userRegister(int $id_user, string $firstName, string $lastName, string $email, string $role)
    {
        $_SESSION['user'] = 
        [ 
            'id_user' => $id_user,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'role' => $role,
        ];
    }

    /**
     * 
     * isConnected
     *
     * @return bool
     */
    public function isConnected(): bool 
    {  
        return array_key_exists('user', $_SESSION) && isset($_SESSION['user']);
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout():void
    {
        if($this->isConnected()){
            $_SESSION['user'] =  null;
            session_destroy();
        }  
    }
    
    /**
     * getUser retourne l'utilisateur connecté
     *
     * @return User|null
     */
    public function getUser()
    {
        return $this->isConnected() ? $_SESSION['user'] : NULL;
    }

    /**
     * isAdmin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        if($this->isConnected()){
            if($_SESSION['user']['role'] === 'Admin'){
                return true;
            }
        }
        return false;
    }
}

