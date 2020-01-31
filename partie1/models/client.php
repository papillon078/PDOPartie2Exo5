<?php

class Client extends Database {
    
    // attributs 
    // (seront utilisés lorsque l'on récuperera des données à partir de formulaires)
    public $id;
    public $lastName;
    public $firstName;
    public $birthDate;
    public $card;
    public $cardNumber;
    
    /**
     * connexion à la base de données
     * le constructeur hérite du construct de la classe parente
     */
    public function __construct(){
        parent::__construct();
    }
    
    
    /**
     * fermeture automatique de la connexion à la destruction de l'instance de classe
     */
    public function __destruct(){
        parent::__destruct();
    }
    
    
    /**
     * méthode permettant de récupérer la liste de tous les clients
     * @return array
     */
    public function getClientList() {
        //definition de la requete SQL 
        $query = 'SELECT `lastName`, `firstName` FROM `clients`';
        
        // soumission de la requete au serveur de bdd
        $result = $this->db->query($query);
        
        // recuperation de la liste des clients sous forme d'un tableau d'objets
        return $result->fetchall(PDO::FETCH_OBJ);
         
    }
    
}

?>