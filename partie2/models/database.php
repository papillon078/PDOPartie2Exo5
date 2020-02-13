<?php
class Database {

    private $serverName = 'localhost';
    private $bddName = 'hospitalE2N';
    private $userName = 'ldcmorin';
    private $password = 'Lunettes78';
    
    protected $db;

    public function __construct(){


        try {
            $this->db = new PDO("mysql:host=$this->serverName;dbname=$this->bddName;charset=utf8", $this->userName, $this->password);
            //$this->db = new PDO('mysql:host='.SERVERNAME.';dbname='.BDDNAME.';charset=utf8', USERNAME, PASSWORD);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            die('echec de la connexion : ' . $e->getMessage());
        }
    }

    public function __destruct() {
        $this->db = null;
    }

}

?>