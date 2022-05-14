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
     * On crée une fonction pour récupérer le candidat via son 
     * @return array
    */
    public function getCandidate($id_candidat): array
    {
        $sql = 'SELECT * FROM Candidat 
                WHERE id_candidat = ? 
                ORDER BY nom       ';
        $candidate = $this->db->getOneResult($sql,[$id_candidat]);

        if (!$candidate){
            return null;
        }
        return $candidate;
    }
    /**
    * Requête pour ajouter un candidat 
    * @return PDOStatement
    */
    public function createCandidate(string $firstName,string $lastName,string $email,string $phone, $pe = null):PDOStatement
    {
        $sql = 'INSERT INTO Candidat (prenom, nom , email, telephone, id_poleEmploi) value (?,?,?,?,?) ';
        return $this->db->prepareAndExecute($sql, [$firstName, $lastName, $email, $phone, $pe]);
    }
}