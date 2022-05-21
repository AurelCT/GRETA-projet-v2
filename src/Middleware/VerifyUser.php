<?php

namespace App\Middleware;

use App\Repository\UserModel;

class VerifyUser
{
      /**
     * Création d'une fonction pour sécuriser le formulaire d'ajout de candidat, gestion des erreurs si une partie du formulaire est vide/ne correspond pas
     * @return array
     */
    public function validateUserForm(string $lastName,string $firstName, string $email, string $password, string $passwordConfirm):array
    {
        $errors = [];

        if(empty($lastName)){
            $errors['lastName'] = 'Le nom est obligatoire';
        }
        if(empty($firstName)){
            $errors['firstName'] = 'Le prénom est obligatoire';
        }
        if(empty($email)){
            $errors['email'] = 'Un email est obligatoire';
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Vérifier que le format est valide
            $errors['email'] = "Veuillez rentrer un format d'email valide";
        }

        if (!$password) { 
        $errors['password'] = 'Le champ "Mot de passe" est obligatoire';
        }

        elseif (strlen($password) < 8) {
        $errors['password'] = 'Le champ "Mot de passe" doit comporter au moins 8 caractères';
        }

        elseif($password != $passwordConfirm) {
        $errors['password-confirm'] = 'Les mots de passe ne sont pas identiques';
        }
        return $errors;    
    }

     /**
     * On vérifie les identifiants de connexion de l'utilisateur
     * Si les identifiants sont corrects, on retourne l'utilisateur
     * False si l'email n'existe pas ou le mot de passe est incorrect
     */
    public function checkUserInformations(string $email, string $password)
    {
        // On va chercher l'utilisateur à partir de l'email
        $user = (new UserModel())->getUserByEmail($email);

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
