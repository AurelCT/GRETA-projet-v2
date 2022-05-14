<?php
namespace App\Controller;
use App\Repository\MeetingModel;
use App\Repository\CandidateModel;

class CandidateController extends AbstractController
{
 
    /**
     * function pour ajouter un nouveau candidat
     */
    public function getAddCandidate()
    {
        var_dump($_POST);
        $errors = [];
        if(!empty($_POST)){
            $lastName = trim($_POST['lastName']);
            $firstName = trim($_POST['firstName']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $pe = trim($_POST['pe']);
            //On récupère notre fonction qui gère les erreurs, si il est vide, on peut valider le formulaire
            $errors = $this->validateCandidateForm($lastName,$firstName,$email, $phone);
            
            if(empty($errors)){
                $newCandidate= (new CandidateModel())->createCandidate($lastName,$firstName,$email, $phone, $pe);
            }
        }
        return $this->render('addCandidate', [
            'errors'=>$errors
        ]);
    }

    public function getCandidate()
    {  
        $meetings = (new MeetingModel())->getAllMeeting();
        $idCandidate = $_GET['id_candidat'];
        $candidate = (new CandidateModel())->getCandidate($idCandidate);

        //possibilité d'ajouter un candidat à une réunion
        if(!empty($_POST)){
            $idMeeting = $_POST['id_meeting'];
            var_dump(intval($idCandidate));
            var_dump($idMeeting);
            $insertCandidate = (new MeetingModel())->addCandidateToMeeting(intval($idMeeting), intval($idCandidate));
        }
        return $this->render('candidate', [
            'candidate'=>$candidate,
            'meetings'=>$meetings
        ]);
    }

    public  function getAllCandidate()
    {
        //On récupère et stock dans une variable notre requête SQL pour les candidats
        $candidates = (new CandidateModel())->getAllCandidate();

        return $this->render('candidates', [
            'candidates'=>$candidates
        ]);

    }

    /**
     * Création d'une fonction pour sécuriser le formulaire d'ajout de candidat, gestion des erreurs si une partie du formulaire est vide/ne correspond pas
     * @return array
     */
    private function validateCandidateForm(string $lastName,string $firstName, string $email, string $phone):array
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
        if(empty($phone)){
            $errors['phone'] = 'Un numéro de téléphone est obligatoire';
        }
        return $errors;    
    }

}