<?php 
namespace App\Controller;
use App\Services\VerifyForm;
use App\Repository\PlaceModel;
use App\Repository\MeetingModel;
use App\Repository\CandidateModel;
use App\Repository\FormationModel;
//Controller des différentes pages d'accueil
class MeetingController extends AbstractController
{
  
    public function getOneMeeting()
    {
        // Valider le paramètre id_event
        if (!array_key_exists('id_event', $_GET) || !$_GET['id_event'] || !ctype_digit($_GET['id_event'])) {
            echo '<p>ERREUR : id de la réunion manquant ou incorrect</p>';
            exit;
        }
        //On récupère l'id de la réunion que l'on veut afficher
        $idMeeting = $_GET['id_event'];
        //On insère l'id dans notre requête pour afficher la réunion
        $meeting = (new MeetingModel())->getOneMeeting($idMeeting) ;

        //test pour savoir si la réunion existe
        if(!$meeting){
            echo 'ERREUR : <p> aucune réunion possédant cet id </p>';
            exit;
        }

        //On récupère les candidats affiliés à la réunion
        $candidates = (new MeetingModel())->getCandidatesPerMeeting($idMeeting);
        //On récupère tous les candidats pour éventuellement les ajouter à la réunion
        $allCandidates = (new CandidateModel())->getAllCandidate();
        // var_dump($meeting);
        return $this->render('meetings/meeting', [
            'meeting'=>$meeting,
            'candidates'=>$candidates,
            'allCandidates' => $allCandidates,
        ]);
    }

    public function getAllMeeting()
    {
        $meetings = (new MeetingModel())->getAllMeeting();
        $formations = (new Meetingmodel())->getAllFormations();

        return $this->render('meetings/allMeeting', [
            'meetings'=>$meetings,
            'formations' => $formations
        ]);
    }

    public function getMeetingForm()
    {
        //On récupère notre tableau des titres de formation  dans une variable
        $formations = (new FormationModel())->getAllFormations();
        //On récupère notre tableau des lieux de réunion  dans une variable
        $places = (new PlaceModel())->getAllPlaceMeeting();
        $errors = [];
        if(!empty($_POST)){    
            //Récupération des données du formulaire envoyé en POST
            $name = trim($_POST['name']);
            $id_formation = trim($_POST['formation']);
            $meetingDate= $_POST['meetingTime'];
            $date = new \DateTimeImmutable($meetingDate);
            $place = trim($_POST['place']);
            $errors =  (new VerifyForm())->validateMeetingForm($name);
            
            if(empty($errors)){
                $meeting = (new MeetingModel())->createMeeting($name,$id_formation,$date,$place);
                header('location: index.php?action=allMeeting');
                exit ;
            }
        }
       
        return $this->render('meetings/createMeeting', [
            'formations'=>$formations,
            'places'=>$places,
            'errors' => $errors,
        ]);
    }

    public function editCandidateInMeeting()
    {
        if(!empty($_POST)){
            $retenu = trim($_POST['retenu']);
            $present = trim($_POST['present']);
            $commentsOnCandidat = trim($_POST['commentsOnCandidat']);
            $meeting_id = trim($_POST['formMeetingIdValue']);
            $candidatId = trim($_POST['formCandidateIdValue']);

            (new MeetingModel())->updateCandidateInMeeting($present ,$retenu, $commentsOnCandidat, $meeting_id, $candidatId);

            header('location: index.php?action=meeting&id_event='.$meeting_id);
            exit;
        }
    }

    /**
     * Supprimer un candidat d'une réunion
     */
    public function deleteCandidatFromMeeting()
    {
        $meeting_id = $_GET['meeting_id'];
        $candidate_id = $_GET['candidate_id'];

        (new MeetingModel())->deleteCandidateFromMeeting($meeting_id, $candidate_id);
        header('location: index.php?action=meeting&id_event='.$meeting_id);
        exit;
    }

    /**
     * Supprimer une réunion
     */
    public function deleteMeeting()
    {
        $meeting_id = $_GET['meeting_id'];
        (new MeetingModel())->deleteMeeting($meeting_id);
        header('location: index.php?action=allMeeting');
        exit;
    }
}