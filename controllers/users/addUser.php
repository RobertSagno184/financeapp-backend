<?php

include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR. "users.php";
// include_once dirname(__DIR__).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR. "personne.php";
include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR. "Db.php";

// traitement des requettes avec post
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"));
    if(!empty($data)){
        $modelUser = new Users(
            $dbi,
            cleanData($data->prenom),
            cleanData($data->nom),
            cleanData($data->genre),
            cleanData($data->telephone)
        );
        $modelUser->setFonction(cleanData($data->fonction));
        if ($modelUser->createUsers()){
            return print json_encode(['reponse'=>"user ".$data->prenom." ".$data->nom." ajouter avec sucess"],http_response_code(200), JSON_PRETTY_PRINT);
        }
    }else{
        return print json_encode(["reponse" => "la liste des donnees est vide"],JSON_PRETTY_PRINT);
    }
}else{
    return print json_encode(["reponse" => "vous n'êtes pas autoriser"],http_response_code(200),JSON_PRETTY_PRINT);

}

function cleanData($data){
    return trim(htmlentities($data));
}