<h1>Lista de Gatos</h1><br>

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

#gatos-lista {
    border: 2px double;
}

#gatos-lista tr, td, th {
    border: 2px double;
    padding: 5px;
    background-color: lightpink;
}

#gatos-lista td {
    background-color: lightpink;
    text-align: center;
}

</style>

<table id="gatos-lista">
<tr>
<th>Id</th>
<th>Nombre</th>
<th>Dueño</th>
<th>Comida Favorita</th>
<th></th>
</tr>
<?php

$apiUrl = $webServer . '/gatos';
$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_ENCODING ,"");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($curl);
$gatos = json_decode($json);
curl_close($curl);

foreach ($gatos as $gato) {
?>
<tr>
    <td><a href="/gatos/view.php?id=<?=$gato->id?>"><?=$gato->id?></a></td>
    <td><?=$gato->nombre ?></td>
    <td><?=$gato->dueno ?></td>
    <td><?=$gato->comida ?></td>
    <td>
        <a href="/gatos/edit.php?id=<?=$gato->id?>"><button>Editar</button></a>
        <a href="/gatos/posts.php?id=<?=$gato->id?>"><button>Posts</button></a>
        <a href="/gatos/delete.php?id=<?=$gato->id?>"><button>Borrar</button></a>
    </td>
</tr>
<?php
}
?>
</table>
<br>
<a href="/gatos/new.php">Nuevo Gato</a>

