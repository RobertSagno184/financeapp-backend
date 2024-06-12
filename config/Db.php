<?php

class Db{
    // les proprietes de la classe

    private $host ="localhost";
    private $dbname = "financedb";
    private $user = "root";
    private $password = "";

    private $options = [PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ];
    // méthode de connexion à la base de donnée
    public function getDbInsttance(){
        $conn = null;
        try {
            $conn = new PDO("mysql:host=$this->host; dbname=$this->dbname", $this->user, $this->password, $this->options);
            //code...
        } catch(PDOException $e){
            die(json_encode("erreur de connexion à la base de données: ".$e->getMessage(), JSON_PRETTY_PRINT));
        }
        return $conn;
    }
  
}
// création de l'instance de la base de données:
$db = new Db();
$dbi= $db->getDbInsttance();