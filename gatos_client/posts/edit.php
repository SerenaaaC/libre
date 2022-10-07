<!-- Este doc es como él de Luis que se llama Modificar es pa modificar posts -->

<h1>Editar Post</h1><br>
<?php
require_once "../config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_GET['id'];
    $apiUrl = $webServer . '/posts/' . $id;

    $params = array("title"     => $_POST['title'],
                    "content"   => $_POST['content'],
                    "status"    => $_POST['status'],
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

	include("detail.php");
} else {
    $id = $_GET["id"];
    $apiUrl = $webServer . '/posts/' . $id;
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_ENCODING ,"");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    $post = json_decode($json);
    curl_close($curl);

    $apiUrl = $webServer . '/gatos';
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_ENCODING ,"");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    $gatos = json_decode($json);
    curl_close($curl);

?>

<form method="post" >
    <label for="id">Id:</label>
    <input type="text" id="id" name="id" value="<?=$post->id?>" disabled>
    <br>
    <label for="title">Título:</label>
    <input type="text" id="title" name="title" value="<?=$post->title?>">
    <br>
    <label for="status">Status:</label>
    <select name="status" id="status">
        <option value="pronunciado" <?=$post->status=="pronunciado"?"selected":""?>>Pronunciado</option>
        <option value="silenciado" <?=$post->status=="silenciado"?"selected":""?>>Silenciado</option>
    </select>
    <br>
    <label for="gato_id">Id del Gato Autor:</label>
    <select name="gato_id" id="gato_id">
<?php
    foreach ($gatos as $gato) {
        $selected = $post->gato_id==$gato->id?"selected":"";
        echo "<option value=$gato->id $selected>$gato->nombre</option>";
    }
?>
    </select>
    <br>
    <label for="content">Lo Que Dice:</label>
    <input type="text" id="content" name="content" value="<?=$post->content?>">
    <br>
    <input type="submit" value="Guardar">
</form>

<?php
}
?>
<br><a href = "/">Volver</a>

