    <?php
    include "Personne.php";
    /**
     * cette classe est la definition de la table client, elle contient
     * toute les actions possibles sur la table client
     * @var string $prenom le prenom du client;
     * @var string $nom le nom du client
     * @var string $genre le genre du client
     * @var string $telephone le numero de telephone du client
     */
    class Client extends Personne{
        private $conn = null;
        private $table = "t_client";
        private $a_table = "t_agence";
        //propreties
        private $create_at;
        private $id;
        private $agence;

        public function __construct($db,$prenom=null,$nom=null,$genre=null,$telephone=null){
            parent::__construct($prenom,$nom,$genre,$telephone);
            if ($this ->conn === null) {
                $this->conn = $db;
            }
        }
        
        public function createClient(){
            $req = "INSERT INTO $this->table (prenom, nom, genre, telephone, agence, create_at) 
                VALUES (:prenom, :nom, :genre, :telephone, :agence, NOW())";
        try {
            $stm = $this->conn->prepare($req);
            return $stm->execute([
                ":prenom" => $this->prenom,
                ":nom" => $this->nom,
                ":genre" => $this->genre,
                ":telephone" => $this->telephone,
                ":agence" => $this->agence
            ]);
        } catch (PDOException $e) {
            die(json_encode(["error" => "Erreur d'insertion d'un client: " . $e->getMessage()], JSON_PRETTY_PRINT));
        }
    }

    /* selectionner l'identifiant du dernier client */
    public function dernierClientId(){
        $req = "SELECT id FROM $this->table ORDER BY id DESC LIMIT 1";

        try{
            $stm =$this->conn-> prepare($req);
            $stm-> execute();
            return $stm;
        }catch(PDOException $e){
            die(json_encode(["error"=>"Lecture dernier client erreur: ".$e->getMessage()], JSON_PRETTY_PRINT));
        }
    }
        public function clientAgence(){
            $req = "SELECT c.prenom, c.nom, c.genre, c.telephone, a.nom, a.adresse
            FROM $this->table c Inner Join $this->a_table a
            ON c.agence = a.id 
            Order by c.create_at DESC";
            
            try{
                $stm =$this->conn-> prepare($req);
                $stm-> execute();
                return $stm;
            }catch(PDOException $e){
                die(json_encode(["error"=>"Lecture client erreur: ".$e->getMessage()], JSON_PRETTY_PRINT));
            }
            
        }
        /* la liste des clients avec les informations sur le compte*/
        public function clientCompte(){
            $req = "SELECT c.prenom, c.nom, c.genre, c.telephone, co.code, co.typ, co.solde
            FROM $this->table c Inner Join t_compte co
            ON c.id = co.client 
            Order by c.create_at DESC";
            
            try{
                $stm =$this->conn-> prepare($req);
                $stm-> execute();
                return $stm;
            }catch(PDOException $e){
                die(json_encode(["error"=>"Lecture client erreur: ".$e->getMessage()], JSON_PRETTY_PRINT));
            }
            
        }
        /* 
            cette methode permet de lire la donnée d'une personne
        */
        public function read_a_client(){
            $req = "Select c.prenom, c.nom, c.genre, c.telephone, a.nom, a.adresse
            From $this->table c Inner Join $this->a_table a
            ON c.agence = a.id 
            WHERE c.id = :id";
            
            try{
                $stm =$this->conn-> prepare($req);
                return $stm-> execute(["id: => $this->id"]);
            }catch(PDOException $e){
                die(json_encode(["error"=>"Lecture d'un client erreur: ".$e->getMessage()], JSON_PRETTY_PRINT));
            }
            
        }

        public function update(){
            $sql = "UPDATE $this->table SET prenom= :prenom, nom= :nom, genre=:genre, telephone=:telephone)
            WHERE id=:id;
            ";
            $values= [
                ":prenom"=> $this->prenom,
                ":nom"=> $this->nom,
                ":genre"=> $this->genre,
                ":telephone"=> $this->telephone,
            ];
            try{
            $query =$this->conn-> prepare($sql);
            return $query->execute($values);
            }catch(PDOException $e){
            die(json_encode(["error"=>"update client erreur: ".$e->getMessage()], JSON_PRETTY_PRINT));
            }
        }

        public function delete (){
            $sql = "DELETE FROM $this->table WHERE id=:id";
            $values = [":id" => $this-> id];
            try{
                $query =$this->conn-> prepare($sql);
                return $query->execute($values);
            }catch(PDOException $e){
                die(json_encode(["error"=>"update client erreur: ".$e->getMessage()], JSON_PRETTY_PRINT));
            }
        }


        
       


        /**
         * Set the value of agence
         *
         * @return  self
         */ 
        public function setAgence($agence)
        {
                $this->agence = $agence;

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

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }
    }
