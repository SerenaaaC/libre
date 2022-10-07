<h1>Nuevo Maullido</h1><br>
<?php
require_once "../config.php";

$gatoId = isset($_GET['gato_id'])?$_GET['gato_id']:null;
$title = "Nuevo Maullido";
if ($gatoId != null) {
    $title .= " del gato " . $gatoId;
}
?>
<h1><?=$title?></h1><br>
<?php

//$maullidoId = $_GET["id"];
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $apiUrl = $webServer . '/maullidos';

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $apiUrl);
	curl_setopt($ch, CURLOPT_POST, 1);

	curl_setopt($ch, CURLOPT_POSTFIELDS, 
        http_build_query($_POST));

	// Receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);

	curl_close ($ch);
    
	$maullido = json_decode($server_output);
    $maullidoId = $maullido->id;

	include("detail.php");
	echo '<br><a href = "/">Volver</a>';
} else {
	$apiUrl = $webServer . '/gatos';
	$curl = curl_init($apiUrl);
	curl_setopt($curl, CURLOPT_ENCODING ,"");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$json = curl_exec($curl);
	$gatos = json_decode($json);
	curl_close($curl);
?>

<form method="post" >
<!--<label for="id">Id:</label>
<input type="hidden" name="id" value="<?//=$maullidoid?>">
<input type="text" id="id" value="<?//=$maullidoid?>" disabled>-->
<br>
<label for="maullido">Maullido:</label>
<input type="text" id="maullido" name="maullido">
<br>
<label for="sonido">Sonido:</label>
<input type="text" id="sonido" name="sonido">
<br>
<label for="gato_id">Id del Gato:</label>
<!--<input type="text" id="gato_id" name="gato_id">-->
<?php
if ($gatoId == null){
?>
	<select name="gato_id" id="gato_id">
<?php
}else{
?>
	<input type="hidden" name="gato_id" value="<?=$gatoId?>">
	<select name="gato_id" id="gato_id" disabled>
<?php
}
foreach ($gatos as $gato) {
	$selected = $gatoId==$gato->id?"selected":"";
	echo "<option value=$gato->id $selected>$gato->nombre</option>";
}
?>
</select>
<br>
<input type="submit" value="Guardar">
</form>
<br><a href = "/">Volver</a>

<?php
}
?>

