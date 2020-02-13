<?php

class Appointment extends Database {
    
    // attributs 
    // (seront utilisés lorsque l'on récuperera des données à partir de formulaires)
    public $id;
    public $dateHour;
    public $idPatients;
    
    
    // initialisation du tableau d'erreurs
    public $formErrors = array();
    
    /**
     * connexion à la base de données
     * le constructeur hérite du construct de la classe parente
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * fermeture automatique de la connexion à la destruction de l'instance de classe
     */
    public function __destruct() {
        parent::__destruct();
    }

    /**
     * méthode permettant de créer un nouveau rendez-vous dans la BDD
     * @return boolean
     */
    public function addAppointment() {

        try {
            //definition de la requete SQL avec des marqueurs nommés
            $query = "INSERT INTO `appointments` (`dateHour`, `idPatients`)
                  VALUES
                  (:dateHour, :idPatients)";
            
            
            // preparation de la requete au serveur de bdd
            $result = $this->db->prepare($query);
            
            // association des marqueurs nommées aux véritables informations
                $result->bindValue(':dateHour', $this->dateHour, PDO::PARAM_STR);
                $result->bindValue(':idPatients', $this->idPatients, PDO::PARAM_INT);
                
                
            // execution de la requete
            // renvoi TRUE en cas de succès sinon FALSE là où j'appelle ma méthode addPatient(ctrl)
            return $result->execute();
            
            
        }
        //bloc catch de renvoi des erreurs
        catch (PDOException $e) {
            die('echec de la connexion : ' . $e->getMessage());
        }
    }
    
    /**
     * méthode permettant de récupérer la liste de tous les rendez-vous
     * @return array
     */
    public function getAppointmentList() {
        
        //definition de la requete SQL 
        $query = "  SELECT  `appointments`.`id`, 
                            `appointments`.`dateHour`,
                            `patients`.`lastname`,
                            `patients`.`firstname`,
                            DATE_FORMAT(`patients`.`birthdate`, '%e/%m/%Y') AS `birthdate`,
                            `patients`.`phone`,
                            `patients`.`mail`
                    FROM `patients`
                    INNER JOIN `appointments` ON `patients`.`id` = `appointments`.`idPatients`
                    ORDER BY `appointments`.`dateHour` DESC";
        
        // soumission de la requete au serveur de bdd
        $result = $this->db->query($query);
        
        // recuperation de la liste des rendez-vous sous forme d'un tableau d'objets
        return $result->fetchall(PDO::FETCH_OBJ);
         
    }  
    
    public function hasUniqueTimeSlot(){
        
        //definition de la requete SQL
        $query = 'SELECT `id`, `dateHour` FROM `appointments` WHERE `dateHour`= :dateHour';
        
        // preparation de la requete au serveur de bdd
            $result = $this->db->prepare($query);
            
        // association des marqueurs nommées aux véritables informations
            $result->bindValue(':dateHour', $this->dateHour, PDO::PARAM_STR);
        
        try{
            $result->execute();
            
            // recuperation du premier créneau de rendez-vous correspondant trouvé dans un objet
            $foundAppointment = $result->fetch(PDO::FETCH_OBJ);
            
            // verification que le créneau du rendez-vous existe deja 
            if (is_object($foundAppointment)){
                return false;
            } else {
                return true;
            }
            
        } catch (PDOException $e) {
             die('erreur : ' . $e->getMessage());
        }
    }
    
}