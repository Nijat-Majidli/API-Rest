<?php

require "connexion_bdd.php";

header("Content-Type:application/json; charset=utf-8");

// On récupére les données envoyées par l'utilisateur dans le tableau $datas
parse_str(file_get_contents("php://input"), $datas);

if ($datas["token"] != sha1(md5("nijatmajidli"))){
    show(null, 403, "Access refused");
}

function show($userInfo, $code, $message){
    // On crée un tableau $informations:
    $informations["data"] = $userInfo;
    $informations["code"] = $code;
    $informations["message"] = $message;
    
    // On convertit le tableau $information en format JSON et on le met dans la variable $result
    $result = json_encode($informations, JSON_UNESCAPED_UNICODE);
    
    // On renvoie la réponse
    echo $result;
}

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
        if(!empty($datas["user_id"])) {
            // Récupérer un seul user
            $id = intval($datas["user_id"]);
            getUser($id);
        } 
        else {
            // Récupérer tous les users
            getUser();
        }
        break;
    
    case 'PUT':
        // Modifier un user
		$id = intval($datas["user_id"]);
		updateUser($id);
		break;    

    default:
        // Requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}


function getUser($id=0) {
    global $db;

    if($id != 0) {
        $requete = "SELECT * FROM users WHERE user_id=".$id ;
        $result = $db->query($requete, PDO::FETCH_ASSOC);

        if ($result->rowCount() > 0) {
            foreach ($result as $ligne) {
                $users[] = array(
                    "id" => $ligne["user_id"],
                    "Prenom_NOM" => $ligne["user_nom_prenom"], 
                    "Téléphone" => $ligne["user_tel"], 
                    "Email" => $ligne["user_email"],
                    "Adresse" => $ligne["user_adresse"],
                    "CP" => $ligne["user_cp"],
                    "Ville" => $ligne["user_ville"],
                    "Pays" => $ligne["user_pays"]);
            }

            show($users, 200, "Le fiche d'utilisateur: ".$ligne['user_nom_prenom']);
        } 
        else 
        {
            show(NULL, 404, "Pas trouve");
        }   
    }
    else 
    {
        $requete = "SELECT * FROM users" ;
        $result = $db->query($requete, PDO::FETCH_ASSOC);

        if ($result->rowCount() > 0) 
        {
            foreach ($result as $ligne) 
            {
                $users[] = array(
                    "id" => $ligne["user_id"],
                    "Prenom_NOM" => $ligne["user_nom_prenom"], 
                    "Téléphone" => $ligne["user_tel"], 
                    "Email" => $ligne["user_email"],
                    "Adresse" => $ligne["user_adresse"],
                    "CP" => $ligne["user_cp"],
                    "Ville" => $ligne["user_ville"],
                    "Pays" => $ligne["user_pays"],
                );
            }

            show($users, 200, "La liste de tous les utilisateurs");
        } 
        else 
        {
            show(NULL, 404, "Pas trouve");
        }   

    }

}


function updateUser($id) {
    global $db;
    global $datas;

    $requete = "UPDATE users SET user_nom_prenom=?, user_tel=?, user_email=?, user_adresse=?, user_cp=?, user_ville=?, user_pays=? WHERE user_id=?" ;
    $result = $db->prepare($requete);
    $result->execute(array($datas["user_nom_prenom"], $datas["user_tel"], $datas["user_email"], $datas["user_adresse"], $datas["user_cp"], $datas["user_ville"], $datas["user_pays"], $id));

    show(array($datas), 200, "Utilisateur a été mis a jour avec succes");
}





?>