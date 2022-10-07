<h1>Editar Gato</h1><br>
<?php
require_once "../config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_GET['id'];
    $apiUrl = $webServer . '/gatos/' . $id;
    $params = array("nombre"     => $_POST['nombre'],
                    "dueno"     => $_POST['dueno'],
                    "comida"   =>  $_POST['comida']);
    $apiUrl .= "?" . http_build_query($params);

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

	// Receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);

	curl_close ($ch);
    
	$result = json_decode($server_output);

	include("detail.php");
} else {
    $id = $_GET["id"];
    $apiUrl = $webServer . '/gatos/' . $id;
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_ENCODING ,"");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    $gato = json_decode($json);
    curl_close($curl);
?>

<form method="post" >
    <label for="id">Id:</label>
    <input type="text" id="id" name="id" value="<?=$gato->id?>" disabled>
    <br>
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="<?=$gato->nombre?>">
    <br>
    <label for="dueno">Dueño:</label>
    <input type="text" id="dueno" name="dueno" value="<?=$gato->dueno?>">
    <br>
    <label for="comida">Comida Favorita:</label>
    <input type="text" id="comida" name="comida" value="<?=$gato->comida?>">
    <br>
    <input type="submit" value="Guardar">
</form>

<?php
}
?>
<br><a href = "/">Volver</a>

