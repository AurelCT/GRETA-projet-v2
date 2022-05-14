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


    public function addCandidateToMeeting(int $meeting_id, int $candidat_id):PDOStatement 
    {
        $sql = 'INSERT INTO Evenement_has_candidat (Evenement_id_event, Candidat_id_candidat) 
                VALUES (?,?) ';
        
        return $this->db->prepareAndExecute($sql, [$meeting_id, $candidat_id]);
    }
 }