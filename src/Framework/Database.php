<?php
namespace App\Framework ;

class Database extends \PDO {

    private \PDO $pdo;
    private static $instance = NULL;
   
    private function __construct()
    {
        $this->pdo = $this->getPDOconnection();
    }

    //Pour ne pas multiplier les connexion à la BDD
    public static function getInstance(): self
    {
        if (is_null(self::$instance)){
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    private function getPDOconnection(): \PDO
    {
        $pdo = new \PDO('mysql:host='. DB_HOST .';dbname='.DB_NAME.';charset=utf8',
        DB_USER,
        DB_PASSWORD
        );
    
        $pdo->exec('SET NAMES UTF8');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); //choix du mode de rapport d'erreur
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            
        return $pdo;
    }
    /*
    *prepare et exécute une requête SQL 
    */    
    /**
     * prepareAndExecute
     *
     * @param  string $sql
     * @param  array $values
     * @return \PDOStatement
     */
    public function prepareAndExecute(string $sql, array $values = []): \PDOStatement
    {
        // $pdo = $this->getPDOconnection();
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute($values);
        
        return $pdoStatement;
    }
    
    /**
     * exécute une requête de sélection et récupère un résultat    
     * getOneResult
     *
     * @param  string $sql
     * @param  array $values
     * @return array
     */
    public function getOneResult(string $sql, array $values=[]): array 
    {
        $pdoStatement = $this->prepareAndExecute($sql, $values);
        $result = $pdoStatement->fetch();
         if(!$result){
             return [];
         }
         return $result;
    }
    
    /**
     * exécute une requête de sélection et récupère tous les résultats    
     * getAllResults
     *
     * @param  string $sql
     * @param  array $values
     * @return array
     */
    public function getAllResults(string $sql, array $values=[]): array 
    {
        $pdoStatement = $this->prepareAndExecute($sql, $values);
        $result = $pdoStatement->fetchAll();
        if(!$result){
            return [];
        }
        return $result;
    }
}