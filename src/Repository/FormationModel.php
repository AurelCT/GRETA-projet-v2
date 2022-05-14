<?php
namespace App\Repository;
use \App\Framework\AbstractModel;
use \App\Entity\Formation;

class FormationModel extends AbstractModel
{
    /**On crée une fonction pour récupérer tous les titres de formation dans notre BDD en bouclant dessus
     * getAllFormations
     *
     * @return array
     */
    public function getAllFormations(): array
    {
        $sql = 'SELECT * FROM formation ORDER BY titreFormation';
        $categories = [];
        foreach($this->db->getAllResults($sql) as $category){
            $categories[] = $category;
        }
        return $categories ;
    }
}