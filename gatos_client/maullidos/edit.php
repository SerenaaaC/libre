<h1>Editar Maullido</h1><br>
<?php
require_once "../config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_GET['id'];
    $apiUrl = $webServer . '/maullidos/' . $id;
    $params = array("maullido"   => $_POST['maullido'],
                    "sonido"     => $_POST['sonido'],
                    "gato_id"   =>  $_POST['gato_id']);
    $apiUrl .= "?" . http_build_query($params);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

	// Receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);

	curl_close ($ch);
    
	$result = json_decode($server_output);

	$maullidoId=$id;
	include("detail.php");
} else {
    $id = $_GET["id"];
    $apiUrl = $webServer . '/maullidos/' . $id;
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_ENCODING ,"");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    $maullido = json_decode($json);
    curl_close($curl);
?>

<form method="post" >
    <label for="id">Id:</label>
    <input type="hidden" name ="id" value="<?=$maullido->id?>">
    <input type="text" id="id" value="<?=$maullido->id?>" disabled>
    <br>
    <label for="maullido">Maullido:</label>
    <input type="text" id="maullido" name="maullido" value="<?=$maullido->maullido?>">
    <br>
    <label for="sonido">Sonido:</label>
    <input type="text" id="sonido" name="sonido" value="<?=$maullido->sonido?>">
    <br>
    <label for="gato_id">Id del Gato:</label>
    <input type="text" id="gato_id" name="gato_id" value="<?=$maullido->gato_id?>">
    <br>
    <input type="submit" value="Guardar">
</form>

<?php
}
?>
<br><a href = "/">Volver</a>

