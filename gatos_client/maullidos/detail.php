<?php
require_once "../config.php";

$apiUrl = $webServer . '/maullidos/' . $maullidoId;

$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_ENCODING ,"");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($curl);
$maullido = json_decode($json);
curl_close($curl);
?>

<form>
<label for="id">Id:</label>
<input type="text" id="id" name="id" value="<?=$maullido->id?>" disabled>
<br>
<label for="maullido">Maullido:</label>
<input type="text" id="maullido" name="maullido" value="<?=$maullido->maullido?>" disabled>
<br>
<label for="sonido">Sonido:</label>
<input type="text" id="sonido" name="sonido" value="<?=$maullido->sonido?>" disabled>
<br>
<label for="gato_id">GatoId:</label>
<input type="text" id="gato_id" name="gato_id" value="<?=$maullido->gato_id?>" disabled>
<br>
</form>
<br>
