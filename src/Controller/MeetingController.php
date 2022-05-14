<?php 
namespace App\Controller;
use App\Repository\MeetingModel;
use App\Repository\FormationModel;
use App\Repository\PlaceModel;
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

        //test pour savoir si l'article existe
        if(!$meeting){
            echo 'ERREUR : <p> aucune réunion possédant cet id </p>';
            exit;
        }

        //On récupère les candidats affiliés à la réunion
        $candidates = (new MeetingModel())->getCandidatesPerMeeting($idMeeting);
        // var_dump($meeting);
        return $this->render('meeting', [
            'meeting'=>$meeting,
            'candidates'=>$candidates
        ]);
    }

    public function getAllMeeting()
    {
        $meetings = (new MeetingModel())->getAllMeeting();
        return $this->render('allMeeting', [
            'meetings'=>$meetings
        ]);
    }

    public function getMeetingForm()
    {
        var_dump($_POST);
        //On récupère notre tableau des titres de formation  dans une variable
        $formations = (new FormationModel())->getAllFormations();
        //On récupère notre tableau des lieux de réunion  dans une variable
        $places = (new PlaceModel())->getAllPlaceMeeting();
        
        if(!empty($_POST)){    
            //Récupération des données du formulaire envoyé en POST
            $name = trim($_POST['name']);
            $id_formation = trim($_POST['formation']);
            $meetingDate= $_POST['meetingTime'];
            $date = new \DateTimeImmutable($meetingDate);
            $place = trim($_POST['place']);
            
            // $newMeeting = new MeetingModel();
            $meeting = (new MeetingModel())->createMeeting($name,$id_formation,$date,$place);
        }
       
        return $this->render('createMeeting', [
            'formations'=>$formations,
            'places'=>$places
        ]);
    }

  
}