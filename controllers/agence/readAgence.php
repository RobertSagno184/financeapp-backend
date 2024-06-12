<?php

include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR. "Agence.php";
include_once dirname(__DIR__,2).DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR. "Db.php";

// traitement des requettes avec post
if ($_SERVER["REQUEST_METHOD"] === "GET"){
    // $data = json_decode(file_get_contents("php://input"));
    $modelAgence = new Agence($dbi);
    $agences=$modelAgence->read();
    if ($agences->rowCount() > 0){
        $agences = $agences->fetchAll();
        return print json_encode(["reponse" => $agences],http_response_code(200),JSON_PRETTY_PRINT);
        # code...
    }else{
        return print json_encode(["reponse" => "la liste des agences est vide"],http_response_code(200),JSON_PRETTY_PRINT);
    }
}else{
    return print json_encode(["reponse" => "vous n'êtes pas autoriser"],JSON_PRETTY_PRINT);

}

/* cette methode permet de nettoyer la valeur envoyer par le frontend */
function cleanData($data){
    return trim(htmlentities($data));
}