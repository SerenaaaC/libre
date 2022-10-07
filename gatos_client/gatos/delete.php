<h1>Delete Gato</h1><br>
<?php
require_once "../config.php";

$id = $_GET["id"];
$apiUrl = $webServer . '/gatos/' . $id;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

// Receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

curl_close ($ch);

$result = json_decode($server_output);

if ($result->deleted == "true") {
    echo "Gato $id has been deleted";
} else {
    echo "ERROR: Can't delete gato $id";
}

?>
<br><a href = "/">Volver</a>
