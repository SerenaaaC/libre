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

// Listar todos los maullidos

if($url == '/maullidos' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    error_log("Listar Maullidos");
    $maullidos = getAllMaullidos($dbConn);
    echo json_encode($maullidos);
}

if($url == '/maullidos' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    error_log("Nuevo Maullido");
    $input = $_POST;
    $id = addMaullido($input, $dbConn);
    if($id){
        $input['id'] = $id;
        $input['link'] = "/maullidos/$id";
    }

    echo json_encode($input);
    return;
}

if(preg_match("/maullidos\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'PUT'){
    error_log("Actualizar maullidos");

    $input = $_GET;
    $id = $matches[1];
    updateMaullido($input, $dbConn, $id);

    $maullido = getMaullido($dbConn, $id);
    echo json_encode($maullido);
    return;
}

if(preg_match("/maullidos\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET'){
    error_log("Get Maullidos");

    $id = $matches[1];
    $maullido = getMaullido($dbConn, $id);

    echo json_encode($maullido);
    return;
}

if(preg_match("/maullidos\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'DELETE'){

    $id = $matches[1];
    error_log("Borrar maullido: ". $id);
    $deletedCount = deleteMaullido($dbConn, $id);
    $deleted = $deletedCount >0?"true":"false";

    echo json_encode([
        'id'=> $id,
        'deleted'=> $deleted
    ]);
    return;
}

/**
 * Get record based on ID
 *
 * @param $db
 * @param $id
 *
 * @return mixed Associative Array with statement fetch
 */

function getMaullido($db, $id) {
    $statement = $db->prepare("SELECT maullidos.*, gatos.id as gato_id, gatos.nombre as gato_nombre, gatos.dueno as gato_dueno, gatos.comida as gato_comida
          FROM maullidos left join gatos on maullidos.gato_id = gatos.id
         WHERE maullidos.id=:id");
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

function deleteMaullido($db, $id) {
    $sql = "DELETE FROM maullidos where id=:id";
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

 // Get all maullidos

 function getAllMaullidos($db) {
    $statement = $db->prepare("SELECT * FROM maullidos");
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

function addMaullido($input, $db){

    $sql = "INSERT INTO maullidos 
          (maullido, sonido, gato_id) 
          VALUES 
          (:maullido, :sonido, :gato_id)";

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
    $allowedFields = ['id', 'maullido', 'sonido', 'gato_id'];

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
    $allowedFields = ['id', 'maullido', 'sonido', 'gato_id'];

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

function updateMaullido($input, $db, $id){

    $fields = getParams($input);

    $sql = "
          UPDATE maullidos 
          SET $fields 
          WHERE id=$id
           ";

    $statement = $db->prepare($sql);

    bindAllValues($statement, $input);
    $statement->execute();

    return $id;
}

?>

