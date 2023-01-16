<?php

include("header.php");

$token = sha1(md5("nijatmajidli"));

$userId = $_GET['user_id'];

// On crée un tableau $datas
$datas = array(
    "token" => $token, 
    "user_id" => $userId
);

// On définit le chemin:
if ($_SERVER["SERVER_NAME"] == "apirest.nijatmajidli.eu")
{
    $curl = curl_init("https://apirest.nijatmajidli.eu/api.php");
}
else if ($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "127.0.0.1")
{
    $curl = curl_init("http://127.0.0.1/ApiRest/api.php");
}

// On définit la méthode de la requête
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET"); //GET, POST, PUT, DELETE

curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($datas));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// On reçois la réponse de "api.php":
$response = curl_exec($curl);

curl_close($curl);

$result = json_decode($response, true);

?>

<div class="card my-5 bg-warning text-light">
  <div class="card-body">
    <h3> <?php echo $result['message']?> </h3> 
  </div>
</div>

<?php

if ($result["code"] == "200") {
?>
    <form method="POST" action="update.php" class="form-group">
<?php
    foreach($result["data"] as $data) {
        foreach($data as $key => $value) {
            if($key=='id')
            {
?>
                <input value='<?php echo $value?>' name='<?php echo $key?>' hidden> 
<?php
            }
            else
            {
                echo "<div class='my-3'> <b>$key</b> : <input value='$value' name='$key' class='form-control' disabled> </div>";
            }
            
        }
    }
?>
        <div class="text-center">
            <button type="button" class="btn btn-primary edit w-25"> Editer </button>   
            <button type="submit" class="btn btn-success validate w-25" style="display:none" onclick="alert('Êtes-vous sûr d\'enregistrer les nouvelles modifications?')"> Enregistrer </button> 
        </div>
    </form>
<?php
}

include("footer.php");

?>


<!-- Javascript -->
<script>
    $(document).ready(function(){
        $(".edit").click(function(){
            $(this).hide();
            $('input').removeAttr('disabled'); 
            $('.validate').show();
        });

        $(".validate").click(function(){
            $(this).hide();
            $('input').attr('disabled'); 
            $('.edit').hide();
        })
    })
    
</script>