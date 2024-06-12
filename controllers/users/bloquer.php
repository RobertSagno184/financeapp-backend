<?php

include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR. "users.php";
include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR. "Db.php";
/* creation de l'instance du model user */
// traitement des requettes avec post
if ($_SERVER["REQUEST_METHOD"]==="PUT"){
    $data = json_decode(file_get_contents("php://input"));
    if(!empty($data)){
        $modelUser = new users(
            $dbi,
            cleanData($data->nom),
            cleanData($data->prenom),
            cleanData($data->genre),
            cleanData($data->telephone),
        );
        $modelUser->setId(cleanData($data->userId));
        if ($modelUser->bloquer()){
            return print json_encode(['reponse'=>"utilisateur bloquer avec success"], http_response_code(200), JSON_PRETTY_PRINT);
        }

    }else{
        return print json_encode(["reponse" => "la liste des donnees est vide"],http_response_code(200), JSON_PRETTY_PRINT);

    } 
}else{
    return print json_encode(["error" => "vous n'êtes pas autoriser"],JSON_PRETTY_PRINT);
}

//cette fonction permet de nettoyer
function cleanData($data){
    return trim(htmlentities($data));
}