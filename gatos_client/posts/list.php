<!-- ésta es la lista de posts y el código pa trabajar con los posts -->

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
$gatoId = isset($_GET['id']) ? $_GET['id'] : null;
$title = "Lista de Posts";
if ($gatoId != null) {
    $title .= " del Gato " . $gatoId;
}
?>
<h1><?= $title ?></h1><br>

<!-- Tabla donde se va a listar todos los posts del gato -->

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

    #un-gato {
        border: 2px double;
    }

    #un-gato tr, td, th {
        border: 2px double;
        padding: 5px;
        background-color: lightpink;
    }

    #un-gato td {
        background-color: lightpink;
        text-align: center;
    }
</style>

<table id="un-gato">
    <tr>
        <th>Id</th>
        <th>Título</th>
        <th>Status</th>
        <th>Lo Que Dice</th>
        <th>Id del Gato Autor</th>
        <th>Nombre del Gato Autor</th>
        <th>Dueño del Gato Autor</th>
        <th></th>
    </tr>
    <?php

    if ($gatoId == null) { // eso es un api simplemente copiar y pegar
        $apiUrl = $webServer . '/posts';
    } else {
        $apiUrl = $webServer . '/gatos/' . $gatoId . "/posts";
    }

    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_ENCODING, "");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    $posts = json_decode($json);
    $gatos = json_decode($json);
    curl_close($curl);

    foreach ($posts as $post) { // eso es pa listar los posts
    ?>
        <tr>
            <td><a href="/posts/view.php?id=<?= $post->id ?>"><?= $post->id ?></a></td>
            <td><?= $post->title ?></td>
            <td><?= $post->status ?></td>
            <td><?= $post->content ?></td>
            <td><?= $post->gato_id ?></td>
            <td><?= $post->gato_nombre ?></td>
            <td><?= $post->gato_dueno ?></td>
            <td>
                <a href="/posts/edit.php?id=<?= $post->id ?>"><button>Editar</button></a> <!-- Eso es pa conectar al doc de modificar -->
                <a href="/posts/delete.php?id=<?= $post->id ?>"><button>Borrar</button></a> <!-- Eso es pa conectar al doc de borrar -->
            </td>
        </tr>
    <?php
    }
    ?>
</table>
<br>
<a href="/posts/new.php<?= $gatoId != null ? '?gato_id=' . $gatoId : '' ?>">Nuevo Post</a>

<!--foreach ($gatos as $gato) {
        $selected = $post->gato_id==$gato->id?"selected":"";
        echo "<option value=$gato->id $selected>$gato->nombre</option>";
    }-->