<h1>Delete Maullido</h1><br>
<?php
require_once "../config.php";

$id = $_GET["id"];
$apiUrl = $webServer . '/maullidos/' . $id;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

// Receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

curl_close ($ch);

$result = json_decode($server_output);

if ($result->deleted == "true") {
    echo "Maullido $id has been deleted";
} else {
    echo "ERROR: Can't delete maullido $id";
}

?>
<br><a href = "/">Volver</a>
