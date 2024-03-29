<?php

include("header.php");

$token = sha1(md5("nijatmajidli"));

$datas = array("token" => $token, "user" => "");

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
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");   //GET, POST, PUT, DELETE

// On envoie le tableau $datas vers api.php
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($datas));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// On reçoit la réponse de "api.php":
$response = curl_exec($curl);

curl_close($curl);

// On le convertit en format tableau
$result = json_decode($response, true);

if ($result["code"] == "200") 
{
?>  
    <form method="GET" action="index.php" class="my-5">
        <div class="form-group">
            <label>Renseigner un nom</label>
            <input type="text" class="form-control mb-2" id="searchBar"> 
            <button type="button" class="btn btn-warning float-right" id="searchButton"> Rechercher </button>  
        </div>
    </form>

    <b> <?php $result['message'] ?></b>  <br><br>

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
else{    
    echo "<b>$result[message]</b>  <br><br>";
}


include("footer.php");

?>


<!-- jQuery codes -->
<script>
    $(document).ready(function(){
        $("#searchButton").click(function(){
            var value = $("#searchBar").val().toLowerCase();
            $("#userTable tr").filter(function(){
                $(this).toggle($(this).text().toLocaleLowerCase().indexOf(value)>-1);
            })
        });

        $("#searchBar").on("keyup", function(){
            var value = $(this).val();
            if(value=="")
            {
                $("#userTable tr").show();
            }
        })
    })
</script>
