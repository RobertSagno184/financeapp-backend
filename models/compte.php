<?php

class Compte{
    private $conn=null;
    private $table="t_compte";
    private $a_table="t_client";
    private $code;
    private $typ;
    private $solde;
    private $client;
    private $create_at;


    public function __construct($db) {
        if ($this ->conn === null) {
            $this->conn = $db;
        }
    }

    /* l'insertion d'agence */
    public function create(){
        $req = "INSERT INTO $this->table (typ, solde, client) 
        VALUES (:typ, :solde, :client)";
    try{
        $stm =$this->conn-> prepare($req);
       return $stm-> execute(
            [
                ":typ"=> $this->typ,
                ":solde"=> $this->solde,
                ":client"=> $this->client,
            ]
            );
    }catch(PDOException $e){
        die(json_encode(["error"=>"Erreur de creation de compte: ".$e->getMessage()], JSON_PRETTY_PRINT));
    }
}
/* la modification d'une agence */
public function update(){
    $sql = "UPDATE $this->table SET typ=:typ
    WHERE code=:code";
    $values= [
        ":typ"=> $this->typ,
        ":code"=> $this->code
    ];
    try{
    $query =$this->conn-> prepare($sql);
    return $query->execute($values);
    }catch(PDOException $e){
    die(json_encode(["error"=>"update compte erreur: ".$e->getMessage()], JSON_PRETTY_PRINT));
    }
}
 /* recuperer le solde d'un compte en fonction de son identifiant */
public function SoldeCompte(){
    $req = "SELECT solde FROM $this->table WHERE code= :code";
    
    try{
        $stm =$this->conn-> prepare($req);
        $stm-> execute([":code"=>$this->code]);
        return $stm;
    }catch(PDOException $e){
        die(json_encode(["error"=>"Lecture solde erreur: ".$e->getMessage()], JSON_PRETTY_PRINT));
    }    
}

/* effectuer un versement ou un retrait d'un montant dans un compte */

public function versementOrRetraitOrVirement(){
    $sql = "UPDATE $this->table SET solde=:solde
    WHERE code=:code";
    $values= [
        ":solde"=> $this->solde,
        ":code"=> $this->code
    ];
    try{
    $query =$this->conn-> prepare($sql);
    return $query->execute($values);
    }catch(PDOException $e){
    die(json_encode(["error"=>"versement compte erreur: ".$e->getMessage()], JSON_PRETTY_PRINT));
    }
}

    /* effectuer un virement d'un montant d'un compte vers un autre*/

    public function virement(){

    }
    /**
     * Get the value of client
     */ 
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set the value of client
     *
     * @return  self
     */ 
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get the value of solde
     */ 
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * Set the value of solde
     *
     * @return  self
     */ 
    public function setSolde($solde)
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * Get the value of typ
     */ 
    public function getTyp()
    {
        return $this->typ;
    }

    /**
     * Set the value of typ
     *
     * @return  self
     */ 
    public function setTyp($typ)
    {
        $this->typ = $typ;

        return $this;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }
}