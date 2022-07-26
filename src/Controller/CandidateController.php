<?php
namespace App\Controller;
use App\Services\VerifyForm;
use App\Repository\MeetingModel;
use App\Repository\CandidateModel;

class CandidateController extends AbstractController
{
 
    /**
     * function pour ajouter un nouveau candidat
     */
    public function getAddCandidate()
    {
        $errors = [];
        if(!empty($_POST)){
            $lastName = trim($_POST['lastName']);
            $firstName = trim($_POST['firstName']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $adress = trim($_POST['adress']);
            $pe = trim($_POST['pe']);
            $peAdvisor = trim($_POST['peAdvisor']);
            $regionCode = trim($_POST['regionCode']);
            $participate = trim($_POST['participate']);
            $bac = trim($_POST['bac']);
            $comments = trim($_POST['comments']);
            //On récupère notre fonction qui gère les erreurs, si il est vide, on peut valider le formulaire
            $errors = (new VerifyForm())->validateCandidateForm($lastName,$firstName,$email);
            
            if(empty($errors)){
                $newCandidate= (new CandidateModel())->createCandidate($lastName,$firstName,$email, $phone,$adress, $pe, $peAdvisor, $regionCode, $participate, $bac, $comments);
                header('location: index.php?action=candidates');
                exit ;
            }
        }
        return $this->render('candidates/addCandidate', [
            'errors'=>$errors
        ]);
    }

    public function getCandidate()
    {  
        $meetings = (new MeetingModel())->getAllMeeting();
        $idCandidate = $_GET['id_candidat'];
        $candidate = (new CandidateModel())->getCandidate($idCandidate);
        $errors = [];
        if(!$candidate){
            echo 'ERREUR : <p> le candidat n\'a pas été trouvé </p>';
            exit;
        }

        //possibilité d'ajouter un candidat à une réunion
        if(!empty($_POST)){
            $idMeeting = $_POST['id_meeting'];
            $errors = (new MeetingModel())->checkCandidateInMeeting($idCandidate, $idMeeting);
            if(empty($errors)){
                $insertCandidate = (new MeetingModel())->addCandidateToMeeting(intval($idMeeting), intval($idCandidate));
            }
        }
        return $this->render('candidates/candidate', [
            'candidate' => $candidate,
            'meetings' => $meetings,
            'errors' => $errors,
        ]);
    }

    public  function getAllCandidate()
    {
        $candidates = (new CandidateModel())->getAllCandidate();
        return $this->render('candidates/candidates', [
            'candidates'=>$candidates
        ]);
    }

    public function editCandidate()
    {
        //Récupération de l'id du candidat
        $idCandidate = $_GET['id_candidat'];
        $candidate = (new CandidateModel())->getCandidate($idCandidate);
        
        $errors = [];
        if(!empty($_POST)){
            $lastName = trim($_POST['lastName']);
            $firstName = trim($_POST['firstName']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $adress = trim($_POST['adress']);
            $pe = trim($_POST['pe']);
            $peAdvisor = trim($_POST['peAdvisor']);
            $regionCode = trim($_POST['regionCode']);
            $participate = trim($_POST['participate']);
            $bac = trim($_POST['bac']);
            $comments = trim($_POST['comments']);
            //On récupère notre fonction qui gère les erreurs, si il est vide, on peut valider le formulaire
            $errors = (new VerifyForm())->validateCandidateForm($lastName,$firstName,$email, $phone);
            
            if(empty($errors)){
                $newCandidate= (new CandidateModel())->editCandidate($lastName,$firstName,$email, $phone,$adress, $pe, $peAdvisor, $regionCode, $participate, $bac, $comments, $idCandidate);
                header('location: index.php?action=candidate&id_candidat='.$idCandidate);
                exit ;
            }
        }
        
        return $this->render('candidates/editCandidate', [
            'candidate' => $candidate,
            'errors'=>$errors,
        ]);
    }

    public function deleteCandidate()
    {
        $idCandidate = $_GET['id_candidat'];
        (new CandidateModel())->deleteCandidate($idCandidate);
        header('location: index.php?action=candidates');
        exit ;
    }
}