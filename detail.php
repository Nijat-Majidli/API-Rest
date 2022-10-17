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
$curl = curl_init("http://127.0.0.1/lmbapi/api.php");

// On définit la méthode de la requête
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET"); //GET, POST, PUT, DELETE

curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($datas));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// On reçois la réponse de "api.php":
$response = curl_exec($curl);

curl_close($curl);

$result = json_decode($response, true);

echo "<b> $result[message] </b> <br><br>";

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
                echo "<b>$key</b> : <input value='$value' name='$key' class='form-control' disabled> <br><br>";
            }
            
        }
    }
?>
        <button type="button" class="btn btn-primary edit"> Editer </button>   
        <button type="submit" class="btn btn-success validate" style="display:none"> Valider </button> 
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