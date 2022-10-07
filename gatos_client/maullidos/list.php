<h1>Listado de Maullidos</h1><br>

<style>
* {
    font-family: calibri, sans-serif;
    font-size: 18px;
    margin-bottom: 10px;
    margin-left: 5px;
}

h1 {
    font-size: 30px;
    font-family: Arial, Helvetica, sans-serif;
}

#tabla-maullidos {
    border: 2px double;
}

#tabla-msullidos tr, td, th {
    border: 2px double;
    padding: 5px;
    background-color: lightpink;
}

#tabla-maullidos td {
    background-color: lightpink;
    text-align: center;
}

</style>

<table id="tabla-maullidos">
<tr>
<th>Id</td>
<th>Maullido</th>
<th>Sonido</th>
<th>Id del Gato</th>
<th></th>
</tr>
<?php

$postId = $_GET["id"];
$apiUrl = $webServer . '/maullidos';
$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_ENCODING ,"");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($curl);
$maullidos = json_decode($json);
curl_close($curl);

foreach ($maullidos as $maullido) {
?>
<tr>
    <td><a href="/maullidos/view.php?id=<?=$maullido->id?>"><?=$maullido->id?></a></td>
    <td><?=$maullido->maullido ?></td>
    <td><?=$maullido->sonido ?></td>
    <td><?=$maullido->gato_id ?></td>
    <td>
        <a href="/maullidos/edit.php?id=<?=$maullido->id?>"><button>Editar</button></a>
        <a href="/maullidos/delete.php?id=<?=$maullido->id?>"><button>Borrar</button></a>
    </td>
</tr>
<?php
}
?>
</table>
<br>
<a href="/maullidos/new.php">Nuevo Maullido</a>

