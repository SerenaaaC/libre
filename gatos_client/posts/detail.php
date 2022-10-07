<?php
require_once "../config.php";

$id = $_GET["id"];
$apiUrl = $webServer . '/posts/' . $id;

$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_ENCODING ,"");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($curl);
$post = json_decode($json);
curl_close($curl);
?>

<form>
<label for="id">Id:</label>
<input type="text" id="id" name="id" value="<?=$post->id?>" disabled>
<br>
<label for="title">Título:</label>
<input type="text" id="title" name="title" value="<?=$post->title?>" disabled>
<br>
<label for="status">Status:</label>
<input type="status" id="status" name="status" value="<?=$post->status?>" disabled>
<br>
<label for="content">Lo Que Dice:</label>
<input type="text" id="content" name="content" value="<?=$post->content?>" disabled>
<br>
<label for="gato_id">Id del Gato Autor:</label>
<input type="text" id="gato_id" name="gato_id" value="<?=$post->gato_id?>" disabled>
<br>
</form>
<br>
