<?php
namespace App\Services;


//Vérification des différents formulaires soumis 
class VerifyForm
{
    /**
     * Création d'une fonction pour sécuriser le formulaire d'ajout de candidat, gestion des erreurs si une partie du formulaire est vide/ne correspond pas
     * @return array
     */
    public function validateCandidateForm(string $lastName,string $firstName, string $email):array
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

        return $errors;    
    }


    public function validateMeetingForm(string $name,)
    {
        $errors = [];
        if(empty($name)){
            $errors['name'] = 'Un nom pour la réunion est obligatoire';
        }

        return $errors;
    }
}
