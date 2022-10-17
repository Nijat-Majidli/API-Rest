<?php

include("header.php");

$token = sha1(md5("nijatmajidli"));

$datas = array(
    "token" => $token,
    "user" => ""
);


// On définit le chemin:
$curl = curl_init("http://127.0.0.1/ApiRest/api.php");

// On définit la méthode de la requête
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET"); //GET, POST, PUT, DELETE

curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($datas));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// On reçois la réponse de "api.php":
$response = curl_exec($curl);

curl_close($curl);

$result = json_decode($response, true);
?>

<form method="GET" action="show.php" class="my-5">
    <div class="form-group">
        <label>Renseigner un nom</label>
        <input type="text" class="form-control mb-2" id="search"> 
        <button type="button" class="btn btn-warning float-right"> Rechercher </button>  
    </div>
</form>

<?php

echo "<b>$result[message]</b>  <br><br>";

if ($result["code"] == "200") {
?>  
    <table class="table table-striped" id="userTable">
        <thead>
            <tr>
                <th scope="col"> </th>
                <th scope="col">Nom</th>
                <th scope="col">Tél</th>
                <th scope="col">Email</th>
                <th scope="col">Adresse</th>
                <th scope="col">Code postale</th>
                <th scope="col">Ville</th>
                <th scope="col">Pays</th>
                <th scope="col">Détail</th>
            </tr>
        </thead>
        <tbody>
<?php
        foreach($result["data"] as $data) {
?>
            <tr>
<?php       
            $id = 0;
            foreach($data as $key => $value) {
                if($key=='id')
                {
                    $id=$value;
                }
?>     
                <td scope="row"> <?php if($key!='id') echo $value ?> </td> 
<?php
            }
?>
                <td scope="row"> <a href="detail.php?user_id=<?php echo $id?>"> <button type="button" class="btn btn-primary"> Voir </button> </a> </td>  
            </tr>
<?php
        }
?>
        </tbody>
    </table>

<?php
}



include("footer.php");

?>

<script>
    $(document).ready(function(){
        $value = $("#search").on("keyup", function(){
            var value = $(this).val().toLowerCase();
            $("#userTable tr").filter(function(){
                $(this).toggle($(this).text().toLocaleLowerCase().indexOf(value)>-1);
            })
        })
    })
</script>
