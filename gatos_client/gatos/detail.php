<?php
require_once "../config.php";

$id = $_GET["id"];
$apiUrl = $webServer . '/gatos/' . $id;

$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_ENCODING ,"");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($curl);
$gato = json_decode($json);
curl_close($curl);
?>

<form>
<label for="id">Id:</label>
<input type="text" id="id" name="id" value="<?=$gato->id?>" disabled>
<br>
<label for="nombre">Nombre:</label>
<input type="text" id="nombre" name="nombre" value="<?=$gato->nombre?>" disabled>
<br>
<label for="dueno">Dueño:</label>
<input type="text" id="dueno" name="dueno" value="<?=$gato->dueno?>" disabled>
<br>
<label for="comida">Comida Favorita:</label>
<input type="text" id="comida" name="comida" value="<?=$gato->comida?>" disabled>
<br>
</form>
<br>
