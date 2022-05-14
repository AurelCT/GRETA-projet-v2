<?php
namespace App\Repository;
use \App\Framework\AbstractModel;

class PlaceModel extends AbstractModel
{
     /**On crée une fonction pour récupérer tous les lieux de réunion dans notre BDD en bouclant dessus
     * getAllPlaceMeeting
     *
     * @return array
     */
    public function getAllPlaceMeeting(): array
    {
        $sql = 'SELECT * FROM Place ORDER BY lieu';
        $categories = [];
        foreach($this->db->getAllResults($sql) as $category){
            $categories[] = $category;
        }
        return $categories ;
    }
}