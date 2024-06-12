<?php
class Agence {
    private $id;
    private $nom;
    private $adresse;
    private $conn=null;
    private $table="t_agence";


    public function __construct($db){
        if ($this ->conn === null) {
            $this->conn = $db;
        }

    }
    /* l'insertion d'agence */
    public function create(){
        $req = "INSERT INTO $this->table (nom, adresse, create_at ) 
        VALUES (:nom,:adresse, NOW())";
    try{
        $stm =$this->conn-> prepare($req);
       return $stm-> execute(
            [
                ":nom"=> $this->nom,
                ":adresse"=> $this->adresse,
            ]
            );
    }catch(PDOException $e){
        die(json_encode(["error"=>"Erreur d'ajout agence: ".$e->getMessage()], JSON_PRETTY_PRINT));
    }
    }

    /* la lecture d'une agence */
    public function read(){
        $req = "SELECT * FROM $this->table"; 
        try{
            $stm =$this->conn-> prepare($req);
            $stm-> execute();
            return $stm;
        }catch(PDOException $e){
            die(json_encode(["error"=>"Lecture agance erreur: ".$e->getMessage()], JSON_PRETTY_PRINT));
        }
        
    }


    /* la modification d'une agence */
    public function update(){
        $sql = "UPDATE $this->table SET nom=:nom, adresse=:adresse
        WHERE id=:id";
        $values= [
            ":nom"=> $this->nom,
            ":adresse"=> $this-> adresse,
            ":id"=> $this->id
        ];
        try{
        $query =$this->conn-> prepare($sql);
        return $query->execute($values);
        }catch(PDOException $e){
        die(json_encode(["error"=>"update agence erreur: ".$e->getMessage()], JSON_PRETTY_PRINT));
        }
    }
    
    /* supression d'une agence */
    
    public function delete(){
        $req= "DELETE FROM $this->table WHERE id=:id";
        try{
        $stm =$this->conn-> prepare($req);
        return $stm->execute([':id' =>$this->id]);

        }catch(PDOException $e){
        die(json_encode(["error"=>"delete agence erreur: ".$e->getMessage()], JSON_PRETTY_PRINT));
        }
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Set the value of adress
     *
     * @return  self
     */ 
    public function setAdresse($adress)
    {
        $this->adresse = $adress;

        return $this;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}