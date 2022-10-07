<!-- Este es el doc para insertar nuevos posts. Acordarse que pa insertar nuevos posts es con POST -->

<?php
require_once "../config.php";

$gatoId = isset($_GET['gato_id'])?$_GET['gato_id']:null;
$title = "Nuevo Post";
if ($gatoId != null) {
    $title .= " del gato " . $gatoId;
}
?>
<h1><?=$title?></h1><br>
<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $apiUrl = $webServer . '/posts';

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $apiUrl);
	curl_setopt($ch, CURLOPT_POST, 1);

	curl_setopt($ch, CURLOPT_POSTFIELDS, 
          http_build_query($_POST));

	// Receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);

	curl_close ($ch);
    
	$post = json_decode($server_output);
    $_GET["id"] = $post->id;

	include("detail.php");
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
<label for="title">Título:</label>
<input type="text" id="title" name="title">
<br>
<label for="status">Status:</label>
<select name="status" id="status">
	<option value="pronunciado">Pronunciado</option>
	<option value="silenciado">Silenciado</option>
</select>
<br>
<label for="gato_id">Id del Gato Autor:</label>
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
<label for="content">Lo Que Dice:</label>
<input type="text" id="content" name="content">
<br>
<input type="submit" value="Guardar">
</form>
<?php
}
?>
<br><a href = "/">Volver</a>

