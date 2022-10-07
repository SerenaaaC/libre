<h1>Nuevo Gato</h1><br>
<?php
require_once "../config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $apiUrl = $webServer . '/gatos';

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $apiUrl);
	curl_setopt($ch, CURLOPT_POST, 1);

	curl_setopt($ch, CURLOPT_POSTFIELDS, 
          http_build_query($_POST));

	// Receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);

	curl_close ($ch);
    
	$gato = json_decode($server_output);
    $_GET["id"] = $gato->id;

	include("detail.php");
	echo '<br><a href = "/">Volver</a>';
} else {
?>

<form method="post" >
<label for="nombre">Nombre:</label>
<input type="text" id="nombre" name="nombre">
<br>
<label for="dueno">Dueño:</label>
<input type="text" id="dueno" name="dueno">
<br>
<label for="comida">Comida Favorita:</label>
<input type="text" id="comida" name="comida">
<br>
<input type="submit" value="Guardar">
</form>
<br><a href = "/">Volver</a>

<?php
}
?>
