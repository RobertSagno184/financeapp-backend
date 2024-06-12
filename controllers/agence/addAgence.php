<?php

include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR. "Agence.php";
include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR. "Db.php";

// traitement des requettes avec post
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $data = json_decode(file_get_contents("php://input"));
    if(!empty($data)){
        $modelAgence = new Agence($dbi);
        $modelAgence->setnom(cleanData($data->nom));
        $modelAgence->setadresse(cleanData($data->adresse));
        // return print json_encode(["reponse" => "la liste des donnees est vide"],http_response_code(200),JSON_PRETTY_PRINT);
        if ($modelAgence->create()){
            return print json_encode(['reponse'=>"Agence ".$data->nom." ajouter avec sucess"],http_response_code(200), JSON_PRETTY_PRINT);
        }
    }else{
        return print json_encode(["reponse" => "la liste des donnees est vide"],http_response_code(200),JSON_PRETTY_PRINT);
    }
}else{
    return print json_encode(["reponse" => "vous n'êtes pas autoriser"],JSON_PRETTY_PRINT);

}

/* cette methode permet de nettoyer la valeur envoyer par le frontend */
function cleanData($data){
    return trim(htmlentities($data));
}