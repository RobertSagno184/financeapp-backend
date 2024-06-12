<?php

include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR. "Client.php";
include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR. "compte.php";
include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR. "Db.php";

// traitement des requettes avec post
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"));

    if(!empty($data)){
        $modelClient = new Client(
            $dbi,
            cleanData($data->prenom),
            cleanData($data->nom),
            cleanData($data->genre),
            cleanData($data->telephone)
        );
        $modelClient->setAgence(cleanData($data->agence));
        if ($modelClient->createClient()){
            $currentClientId = $modelClient->dernierClientId();
            $currentClientId = $currentClientId->fetch();
            /* ajout compte client */
            $modelCompt = new Compte($dbi);
            $modelCompt->setTyp(cleanData($data->typ));
            $modelCompt->setSolde(cleanData($data->solde));
            $modelCompt->setClient(cleanData($currentClientId->id));
            if($modelCompt->create()){
                return print json_encode(['reponse'=>"Client ".$data->prenom." ".$data->nom." ajouter avec sucess"],http_response_code(200), JSON_PRETTY_PRINT);
            }
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