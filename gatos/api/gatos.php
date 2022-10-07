<?php
$url = $_SERVER['REQUEST_URI'];
if(strpos($url,"/") !== 0){
    $url = "/$url";
}

$dbInstance = new DB();
$dbConn = $dbInstance->connect($db);

header("Content-Type:application/json");
error_log("URL: " . $url);
error_log("METHOD: " . $_SERVER['REQUEST_METHOD']);

// Listar todos los gatos

if($url == '/gatos' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    error_log("Listar Gatos");
    $gatos = getAllGatos($dbConn);
    echo json_encode($gatos);
}

if(preg_match("/gatos\/([0-9]+)\/posts/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET'){
    error_log("Listar posts del gato");

    $gatoId = $matches[1];
    $posts = getPosts($dbConn, $gatoId);
    echo json_encode($posts);
    return;
}

// Añadir gatos

if($url == '/gatos' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    error_log("Crear gato");
    $input = $_POST;
    $gatoId = addGato($input, $dbConn);
    if($gatoId){
        $input['id'] = $gatoId;
        $input['link'] = "/gatos/$gatoId";
    }

    echo json_encode($input);

}

// Actualizar gatos

if(preg_match("/gatos\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'PUT'){
    error_log("Actualizar gato");

    $input = $_GET;
    $gatoId = $matches[1];
    updateGato($input, $dbConn, $gatoId);

    $gato = getGato($dbConn, $gatoId);
    echo json_encode($gato);
}

// Get gatos

if(preg_match("/gatos\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET'){
    error_log("Get Gato");

    $gatoId = $matches[1];
    $gato = getGato($dbConn, $gatoId);

    echo json_encode($gato);
}

// Borrar gato

if(preg_match("/gatos\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'DELETE'){

    $gatoId = $matches[1];
    error_log("Delete Gato: ". $gatoId);
    $deletedCount = deleteGato($dbConn, $gatoId);
    $deleted = $deletedCount >0?"true":"false";

    echo json_encode([
        'id'=> $gatoId,
        'deleted'=> $deleted
    ]);
}

/**
 * Get record based on ID
 *
 * @param $db
 * @param $id
 *
 * @return mixed Associative Array with statement fetch
 */

 // Function get gato

function getGato($db, $id) {
    $statement = $db->prepare("SELECT * FROM gatos where id=:id");
    $statement->bindValue(':id', $id);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

 /**
 * Delete record based on ID
 *
 * @param $db
 * @param $id
 * 
 * @return integer number of deleted records
 */
 

// Function borrar gato

function deleteGato($db, $id) {
    $sql = "DELETE FROM gatos where id=:id";
    $statement = $db->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    return $statement->rowCount();
}

/**
 * Get all records
 *
 * @param $db
 * @return mixed fetchAll result
 */

 // Get all gatos

function getAllGatos($db) {
    $statement = $db->prepare("SELECT * FROM gatos");
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    return $statement->fetchAll();
}

/**
 * Add record
 *
 * @param $input
 * @param $db
 * @return integer id of the inserted record
 */

// Function añadir gato

function addGato($input, $db){

    $sql = "INSERT INTO gatos 
          (nombre, dueno, comida) 
          VALUES 
          (:nombre, :dueno, :comida)";

    $statement = $db->prepare($sql);

    bindAllValues($statement, $input);

    $statement->execute();

    return $db->lastInsertId();
}

/**
 * @param $statement
 * @param $params
 * @return PDOStatement
 */

function bindAllValues($statement, $params){
    $allowedFields = ['nombre', 'dueno', 'comida'];

    foreach($params as $param => $value){
        if(in_array($param, $allowedFields)){
            error_log("bind $param $value");
            $statement->bindValue(':'.$param, $value);
        }
    }
    return $statement;
}

/**
 * Get fields as parameters to set in record
 *
 * @param $input
 * @return string
 */

function getParams($input) {
    $allowedFields = ['nombre', 'dueno', 'comida'];

    foreach($input as $param => $value){
        if(in_array($param, $allowedFields)){
                $filterParams[] = "$param=:$param";
        }
    }

    return implode(", ", $filterParams);
}


/**
 * Update Record
 *
 * @param $input
 * @param $db
 * @param $id
 * @return integer number of updated records
 */

// Actualizar gatos

function updateGato($input, $db, $id){

    $fields = getParams($input);

    $sql = "
          UPDATE gatos 
          SET $fields 
          WHERE id=$id
           ";

    $statement = $db->prepare($sql);

    bindAllValues($statement, $input);
    $statement->execute();

    return $id;
}

/**
 * Get all posts of the gato
 *
 * @param $db
 * @param $gatoId
 * @return mixed fetchAll result
 */

// Function get posts de cada gato, foreign key de gatos está en posts es gato_id

function getPosts($db, $gatoId) {
    $statement = $db->prepare("
        SELECT posts.*, gatos.nombre as gato_nombre, gatos.dueno as gato_dueno, gatos.comida as gato_comida
          FROM posts left join gatos on posts.gato_id = gatos.id
         WHERE gato_id = $gatoId");
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    return $statement->fetchAll();
}

?>


