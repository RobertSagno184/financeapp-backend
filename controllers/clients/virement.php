<?php

include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR. "Client.php";
include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR. "compte.php";
include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR. "Db.php";

// traitement des requettes avec post
if ($_SERVER["REQUEST_METHOD"] == "PUT"){
    $data = json_decode(file_get_contents("php://input"));

    if(!empty($data)){
        // $modelClient = new Client($dbi, null, null, null, null);
        
        
        /* ajout compte client */
        $modelCompt = new Compte($dbi);

        $idEmetteur = intval($data->idEmetteur);
        $idRecepteur = intval($data->idRecepteur);
        $soldeVirement = intval($data->soldeVirement);
        /* traitement des informations du client qui effectue le vierement */
        $modelCompt->setCode($idEmetteur);
        $ancienSolde =floatval($modelCompt->SoldeCompte()->fetch()->solde);
        $nouveauSolde = floatval(cleanData($data->soldesaisie));
        if ($nouveauSolde>$ancienSolde) {
            return print json_encode(["reponse" => "impossible, votre actuel est inferieur"],JSON_PRETTY_PRINT);
            # code...
        }
        $soldeActuel = $ancienSolde-$nouveauSolde;  
        $modelCompt->setSolde($nouveauSolde);
        if($modelCompt->versementOrRetraitOrVirement()){
            
            return print json_encode(['reponse'=>"versement de ".$data->soldesaisie." "." effectuer avec sucess. nouveau solde est: ".$nouveauSolde],http_response_code(200), JSON_PRETTY_PRINT);
        }
    }else{
        return print json_encode(["reponse" => "aucune donnee dans la requette"],JSON_PRETTY_PRINT);
    }
}else{
        return print json_encode(["reponse" => "vous n'êtes pas autoriser"],http_response_code(200),JSON_PRETTY_PRINT);

}

function cleanData($data){
    return trim(htmlentities($data));
}