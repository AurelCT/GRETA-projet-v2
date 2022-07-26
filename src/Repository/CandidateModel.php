<?php
namespace App\Repository;
use PDOStatement;
use App\Framework\AbstractModel;

class CandidateModel extends AbstractModel
{
    /**
    * On crée une fonction pour récupérer tous les candidats dans notre BDD en bouclant dessus
    * 
    *
    * @return array
    */
    public function getAllCandidate(): array
    {
        $sql = 'SELECT * FROM Candidat ORDER BY nom';
        $categories = [];
        foreach($this->db->getAllResults($sql) as $category){
            $categories[] = $category;
        }
        return $categories ;
    }
    
    /**
     * On crée une fonction pour récupérer le candidat via son id
     * @return array
    */
    public function getCandidate($id_candidat): array
    {
        $sql = 'SELECT * FROM Candidat 
                WHERE id_candidat = ? 
                ORDER BY nom       ';
        $candidate = $this->db->getOneResult($sql,[$id_candidat]);

        return $candidate;
    }

    /**
     * On crée une fonction pour récupérer le candidat via son id
     * @return array
    */
    public function getCandidatePerName($name_candidat):array
    {
        $sql = 'SELECT * FROM Candidat 
                WHERE nom = ? 
                ORDER BY nom ';
        $candidate = $this->db->getOneResult($sql,[$name_candidat]);
        // if(!$candidate){
        //     return null;
        // }
        return $candidate;
    }

    /**
    * Requête pour ajouter un candidat 
    * @return PDOStatement
    */
    public function createCandidate(string $firstName,string $lastName,string $email,string $phone, string $adress = null, string $pe = null, string $peAdvisor = null,string $regionCode = null,string $participate = null, string $bac = null, string $comments = null):PDOStatement
    {
        $sql = 'INSERT INTO Candidat (prenom, nom , email, telephone, adresse, id_poleEmploi, conseillerPE,codeRegion,participation,bac, commentairesReunion) value (?,?,?,?,?,?,?,?,?,?,?) ';
        return $this->db->prepareAndExecute($sql, [$firstName, $lastName, $email, $phone, $adress, $pe, $peAdvisor, $regionCode, $participate, $bac, $comments]);
    }

    /**
     * Requête pour éditer un candidate
     * @return PDOStatement
     */
    public function editCandidate(string $firstName,string $lastName,string $email,string $phone, string $adress = null, string $pe = null, string $peAdvisor = null,string $regionCode = null,string $participate = null, string $bac = null, string $comments = null, $idCandidat):PDOStatement
    {
        $sql = 'UPDATE Candidat
                SET prenom = ? , nom = ? , email = ? , telephone = ? , adresse = ? , id_poleEmploi = ? , conseillerPE = ? , codeRegion = ?, participation = ? , bac = ? , commentairesReunion = ?
                WHERE id_candidat = ?';

        return $this->db->prepareAndExecute($sql, [$firstName, $lastName, $email, $phone, $adress, $pe, $peAdvisor, $regionCode, $participate, $bac, $comments, $idCandidat]);
    }

    public function deleteCandidate($deleteCandidate):PDOStatement
    {
        $sql = 'DELETE FROM Candidat 
                WHERE id_candidat = ?';
        return $this->db->prepareAndExecute($sql, [$deleteCandidate]);
    }
}