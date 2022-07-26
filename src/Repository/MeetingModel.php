<?php 
namespace App\Repository;
use \App\Framework\AbstractModel;
use PDOStatement;

 class MeetingModel extends AbstractModel 
 {

     /**
     * createNewMeeting
     *
     * @param  string $name
     * @param  int $id_formation
     * @param  DateTimeImmutable $createdAt
     * @param  int $place
     * @return void
     */
    public function createMeeting(string $name, int $id_formation, \DateTimeImmutable $meetingDate, int $place ):PDOStatement
    {
        $sql = 
                'INSERT INTO Evenement (name, id_formation, meetingDate, lieu_id) 
                 VALUES (?, ?, ?, ?)'; 
                return $this->db->prepareAndExecute($sql, [$name, $id_formation, $meetingDate->format('Y,m,d G:i'), $place]);
    }



    /**
     * getOneMeeting
     *
     * @param  int $idMeeting
     * @return array
     */
    public function getOneMeeting(int $idMeeting):?array
    {
        $sql = 'SELECT id_event,name, A.id_formation, meetingDate, lieu_id,createdAt , titreFormation
        FROM Evenement as A 
        INNER JOIN formation as F on A.id_formation = F.id_formation
        WHERE id_event = ?
        ORDER BY createdAt DESC ' ;

        $meeting = $this->db->getOneResult($sql,[$idMeeting]);

        if (!$meeting){
            return null;
        }
        return $meeting;
    }

    /**
     * Fonction pour récupèrer toute les réunions
     * @return array
     */
    public function getAllMeeting():array
    {
        $sql = 'SELECT *
                FROM Evenement as A
                INNER JOIN formation as F on A.id_formation = F.id_formation
                ORDER BY meetingDate DESC';
        $meetings = $this->db->getAllResults($sql);    
        return $meetings;            
    }
    /**
     * Fonction pour récupèrer toute les réunions selon la formation 
     * @return array
     */
    public function getAllMeetingPerFormation($formation_title):array
    {
        $sql = 'SELECT *
                FROM Evenement as A
                INNER JOIN formation as F on A.id_formation = F.id_formation
                WHERE F.titreFormation = ?
                ORDER BY meetingDate DESC';
        $meetings = $this->db->getAllResults($sql, [$formation_title]);    
        return $meetings;            
    }

    /**
     * Récupérer tous les candidats selon la réunion
     */
    public function getCandidatesPerMeeting($id_event):array
    {
        $sql = 'SELECT * FROM Evenement_has_Candidat
                INNER JOIN Candidat as C
                WHERE Evenement_id_event = ?
                AND C.id_candidat = Evenement_has_Candidat.Candidat_id_candidat
        ';
        $candidates = $this->db->getAllResults($sql, [$id_event]);
        return $candidates;
    }
    

    public function getAllFormations():array
    {
        $sql = 'SELECT *
            FROM formation as A
            ORDER BY titreFormation ASC';
        $formations = $this->db->getAllResults($sql);    
        return $formations;  
    }


    public function addCandidateToMeeting(int $meeting_id, int $candidat_id):PDOStatement 
    {
        $sql = 'INSERT INTO Evenement_has_candidat (Evenement_id_event, Candidat_id_candidat) 
                VALUES (?,?) ';
        
        return $this->db->prepareAndExecute($sql, [$meeting_id, $candidat_id]);
    }

    //Vérifier si l'utilisateur est déjà inscrit
    public function checkCandidateInMeeting(int $candidate_id, int $meeting_id): array
    {
        $errors = [];
        $sql = 'SELECT * FROM Evenement_has_Candidat
                WHERE  Candidat_id_candidat = ? AND Evenement_id_event = ?  ';
        $userExist = $this->db->getOneResult($sql,[$candidate_id, $meeting_id]);
        if($userExist){
            $errors['userExist'] = "L'utilisateur est déjà inscrit à la réunion";
        }
        return $errors;
    }

    //Update candidat dans une réunion
    public function updateCandidateInMeeting( string $present, string $retenu, string $commentaires, int $meeting_id , int $candidat_id):PDOStatement
    {
        $sql = 'UPDATE Evenement_has_Candidat
                SET present = ? , retenu = ? , commentaires = ? 
                WHERE Evenement_id_event = ? AND Candidat_id_candidat = ?';
        return $this->db->prepareAndExecute($sql, [$present, $retenu ,$commentaires, $meeting_id, $candidat_id]);
    }

    //Supprimer un candidat de la réunion
    public function deleteCandidateFromMeeting($meeting_id, $candidate_id):PDOStatement
    {
        $sql = 'DELETE FROM Evenement_has_Candidat
                WHERE Evenement_id_event = ? AND Candidat_id_candidat = ?';
        return $this->db->prepareAndExecute($sql, [$meeting_id, $candidate_id]);    
    }

    /**
     * Supprimer une réunion
     */
    public function deleteMeeting($meeting_id):PDOStatement
    {
        $sql = 'DELETE FROM Evenement
                WHERE id_event = ?';
        return $this->db->prepareAndExecute($sql, [$meeting_id]); 
    }
 }