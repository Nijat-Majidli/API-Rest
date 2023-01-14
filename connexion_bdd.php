<?php 

// Vérifie si on désire se diriger vers le serveur apirest.nijatmajidli.eu ou bien vers le serveur local.
// Dans ce cas, host,login, password et BDD sont différents d'un serveur à l'autre:
if ($_SERVER["SERVER_NAME"] == "apirest.nijatmajidli.eu")
{
    // Paramètres de connexion serveur distant
    $host = "localhost";
    $login= "u988716521_nijatm";      // Votre login d'accès au serveur de BDD 
    $password="Mercanli1985@";          // Le Password pour vous identifier auprès du serveur
    $base = "u988716521_apirest";      // La BDD avec laquelle vous voulez travailler 
}
else if ($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "127.0.0.1")
{
    // Paramètres de connexion serveur local
    $host = "localhost";
    $login= "root";     // Votre loggin d'accès au serveur de BDD 
    $password="";    // Le Password pour vous identifier auprès du serveur
    $base = "apirest";    // La bdd avec laquelle vous voulez travailler 
}


try
{    
    //Instanciation de la connexion à la base de données   
    $db = new PDO('mysql:host='.$host.';  charset=utf8;  dbname='.$base.'',  $login, $password);

    // Configure des attributs PDO au gestionnaire de base de données
    // Ici nous configurons l'attribut ATTR_ERRORMODE en lui donnant la valeur ERRMODE_EXCEPTION pour afficher des détails sur l'erreur avec un message beaucoup plus clair:
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}

//Si échec de la connexion (du try), on attrape l'exception avec catch
catch (Exception $e) 
{
    echo "La connection à la base e données a échoué ! <br>";
    echo "Merci de bien vérifier vos paramètres de connection ...<br>";
    echo "Erreur : " . $e->getMessage() . "<br>";   // On affiche le message de l'erreur
    echo "N° : " . $e->getCode(). "<br>";           // On affiche le code de l'erreur
    die("Fin du script");
    //Le script s'arrête ici.
} 


?>