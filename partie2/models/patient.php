<?php

class Patient extends Database {

    // attributs 
    // (seront utilisés lorsque l'on récuperera des données à partir de formulaires)
    public $id;
    public $lastname;
    public $firstname;
    public $birthdate;
    public $phone;
    public $mail;
    
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
     * méthode permettant d'inscrire un nouveau patient dans la BDD
     * @return boolean
     */
    public function addPatient() {

        try {
            echo "etape 0";
            //definition de la requete SQL avec des marqueurs nommés
            $query = "INSERT INTO `patients` (`lastname`, `firstname`, `birthdate`, `phone`, `mail`)
                  VALUES
                  (:lastname, :firstname, :birthdate, :phone, :mail)";
            
            
            // preparation de la requete au serveur de bdd
            $result = $this->db->prepare($query);
            
            // association des marqueurs nommées aux véritables informations
                $result->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
                $result->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
                $result->bindValue(':birthdate', $this->birthdate, PDO::PARAM_STR);
                $result->bindValue(':phone', $this->phone, PDO::PARAM_STR);
                $result->bindValue(':mail', $this->mail, PDO::PARAM_STR);
                
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
     * méthode permettant de récupérer la liste de tous les patients
     * @return array
     */
    public function getPatientList() {
        
        //definition de la requete SQL 
        $query = 'SELECT `id`, `lastname`, `firstname`, `birthdate`, `phone`, `mail` FROM `patients` ORDER BY `id` DESC';
        
        // soumission de la requete au serveur de bdd
        $result = $this->db->query($query);
        
        // recuperation de la liste des clients sous forme d'un tableau d'objets
        return $result->fetchall(PDO::FETCH_OBJ);
         
    }
    
    public function hasUniqueMail(){
        
        //definition de la requete SQL
        $query = 'SELECT `id`, `mail` FROM `patients` WHERE `mail`= :mail';
        
        // preparation de la requete au serveur de bdd
            $result = $this->db->prepare($query);
            
        // association des marqueurs nommées aux véritables informations
            $result->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        
        try{
            $result->execute();
            
            // recuperation du premier email correspondant trouvé dans un objet
            $check = $result->fetch(PDO::FETCH_OBJ);
            
            // verification que le mail existe deja ET appartient à un autre patient
            if (is_object($check) && $check->id !== $this->id){
                return false;
            } else {
                return true;
            }
            
        } catch (PDOException $e) {
             die('erreur : ' . $e->getMessage());
        }
    }
    
    public function getPatientByMail(){
        
        //definition de la requete SQL
        $query = 'SELECT `id` FROM `patients` WHERE `mail`= :mail';
        
        // preparation de la requete au serveur de bdd
            $result = $this->db->prepare($query);
            
        // association des marqueurs nommées aux véritables informations
            $result->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        
        try{
            $result->execute();
            
            // recuperation du premier email correspondant trouvé dans un objet
            return $result->fetch(PDO::FETCH_OBJ);
            
        } catch (PDOException $e) {
             die('erreur : ' . $e->getMessage());
        }
    }
    
    /**
     * méthode permettant de récupérer profil d'un patient
     * @return array
     */
    public function getPatientProfile() {
        try{
        // définition de la requête sql
        $query = "SELECT    `id`,
                            `lastname`, 
                            `firstname`, 
                            DATE_FORMAT(`birthdate`, '%e/%m/%Y') AS `birthdate`,
                            `birthdate` AS `birthdate2`,
                            `phone`, 
                            `mail` 
                FROM `patients` 
                WHERE `id` = :id";

         // soumission de la requête au serveur de la base de données
        $result = $this->db->prepare($query);

        // association des marqueurs nommés aux véritables informations
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);

        $result->execute();
        
        // récupération de la liste des patients sous forme d'un tableau d'objets
        return $result->fetch(PDO::FETCH_OBJ);
        
    }
    catch (PDOException $e) {
        die('erreur : ' . $e->getMessage());
   }
}

    /**
     * méthode permettant de mettre à jour le profil d'un patient
    * @return boolean
    */
    public function updatePatient() {

        try{

            // définition de la requête sql
            $query = "  UPDATE  `patients`
                        SET     `lastname` = :lastname, 
                                `firstname` = :firstname,
                                `birthdate` = :birthdate,
                                `phone` = :phone,
                                `mail` = :mail
                        WHERE   `id` = :id";

            // preparation de la requete au serveur de bdd
            $result = $this->db->prepare($query);
                
            // association des marqueurs nommées aux véritables informations
            $result->bindValue(':id', $this->id, PDO::PARAM_INT);
            $result->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
            $result->bindValue('firstname', $this->firstname, PDO::PARAM_STR);
            $result->bindValue(':birthdate', $this->birthdate, PDO::PARAM_STR);
            $result->bindValue(':phone', $this->phone, PDO::PARAM_STR);
            $result->bindValue(':mail', $this->mail, PDO::PARAM_STR);
                
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
     * méthode permettant de récupérer l'id d'un patient grace à son e-mail
     * @return integer
     */
    public function getPatientIdByMail() {
        try{
        // définition de la requête sql
        $query = "SELECT `id`
                  FROM `patients` 
                  WHERE `mail` = :mail";

         // soumission de la requête au serveur de la base de données
        $result = $this->db->prepare($query);

        // association des marqueurs nommés aux véritables informations
        $result->bindValue(':mail', $this->mail, PDO::PARAM_STR);

        $result->execute();
        
        // récupération de l'id du patient correspndant au mail renseigné 
        // sous forme d'un objet
        return $result->fetch(PDO::FETCH_OBJ);
        
    }
    catch (PDOException $e) {
        die('erreur : ' . $e->getMessage());
   }
}
            
} 


?>
