<?php

include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR. "Client.php";
include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR. "Db.php";

// traitement des requettes avec post
if ($_SERVER["REQUEST_METHOD"] === "PUT"){
    $data = json_decode(file_get_contents("php://input"));
    if(!empty($data)){
        $modelClient = new Client($dbi);
        $modelClient->setPrenom(cleanData($data->prenom));
        $modelClient->setNom(cleanData($data->nom));
        $modelClient->setGenre(cleanData($data->genre));
        $modelClient->setTelephone(cleanData($data->telephone));
        $modelClient -> setId(cleanData($data->id));
        // return print json_encode(["reponse" => "la liste des donnees est vide"],http_response_code(200),JSON_PRETTY_PRINT);
        if ($modelClient->update()){
            return print json_encode(['reponse'=>"Client ".$data->nom." modifier avec sucess"],http_response_code(200), JSON_PRETTY_PRINT);
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