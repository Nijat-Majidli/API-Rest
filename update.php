<?php

include("header.php");

$token = sha1(md5("nijatmajidli"));
$userId = $_POST['id'];
$userNom = $_POST['Prenom_NOM'];
$userTel = $_POST['Téléphone'];
$userEmail = $_POST['Email'];
$userAdr = $_POST['Adresse'];
$userCP = $_POST['CP'];
$userVille = $_POST['Ville'];
$userPays = $_POST['Pays'];

// On crée un tableau $datas
$datas = array(
    "token" => $token, 
    "user_id" => $userId,
    "user_nom_prenom" => $userNom,
    "user_tel" => $userTel,
    "user_email" => $userEmail,
    "user_adresse" => $userAdr,
    "user_cp" => $userCP,
    "user_ville" => $userVille,
    "user_pays" => $userPays,
);

// On définit le chemin:
$curl = curl_init("http://127.0.0.1/ApiRest/api.php");

// On définit la méthode de la requête
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT"); //GET, POST, PUT, DELETE

curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($datas));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// On reçois la réponse de "api.php":
$response = curl_exec($curl);

curl_close($curl);

$result = json_decode($response, true);

?>

<div class="alert alert-success mt-5" role="alert">
    <?php echo $result['message'] ?> 
</div>

<?php
if ($result["code"] == "200") {
    //Redirection vers la page show.php aprés 2 secondes 
    header("refresh:2; url=show.php");

exit;
?>
    <form method="post" action="update.php">
<?php
        foreach($result["data"] as $data) {
            foreach($data as $key => $value) {
                if($key!='token' AND $key!='user_id')
                {
                    echo "$key: $value <br>";
                }
                
            }
        }
?>
    </form>
<?php
}

include("footer.php");
?>