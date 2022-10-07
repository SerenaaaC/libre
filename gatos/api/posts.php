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
if($url == '/posts' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    error_log("Listar posts");
    $posts = getAllPosts($dbConn);
    echo json_encode($posts);
}

/*if(preg_match("/posts\/([0-9]+)\/maullidos/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET'){
    error_log("List maullidos");

    $postId = $matches[1];
    $maullidos = getMaullidos($dbConn, $postId);
    echo json_encode($maullidos);
    return;
}*/

if($url == '/posts' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    error_log("Crear post");
    $input = $_POST;
    $postId = addPost($input, $dbConn);
    if($postId){
        $input['id'] = $postId;
        $input['link'] = "/posts/$postId";
    }

    echo json_encode($input);
}

if(preg_match("/posts\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'PUT'){
    error_log("Actualizar post");

    $input = $_GET;
    $postId = $matches[1];
    updatePost($input, $dbConn, $postId);

    $post = getPost($dbConn, $postId);
    echo json_encode($post);
}

if(preg_match("/posts\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET'){
    error_log("Get post");

    $postId = $matches[1];
    $post = getPost($dbConn, $postId);

    echo json_encode($post);
}

if(preg_match("/posts\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'DELETE'){

    $postId = $matches[1];
    error_log("Borrar post: ". $postId);
    $deletedCount = deletePost($dbConn, $postId);
    $deleted = $deletedCount >0?"true":"false";

    echo json_encode([
        'id'=> $postId,
        'deleted'=> $deleted
    ]);
}

/**
 * Get Record based on ID
 *
 * @param $db
 * @param $id
 *
 * @return mixed Associative Array with statement fetch
 */

function getPost($db, $id) {
    $statement = $db->prepare("SELECT posts.*, gatos.id as gato_id, gatos.nombre as gato_nombre, gatos.dueno as gato_dueno, gatos.comida as gato_comida
          FROM posts left join gatos on posts.gato_id = gatos.id
         WHERE posts.id=:id");
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

function deletePost($db, $id) {
    $sql = "DELETE FROM posts where id=:id";
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

function getAllPosts($db) {
    $statement = $db->prepare("SELECT posts.*, gatos.id as gato_id, gatos.nombre as gato_nombre, gatos.dueno as gato_dueno, gatos.comida as gato_comida 
          FROM posts left join gatos on posts.gato_id = gatos.id");
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

function addPost($input, $db){

    $sql = "INSERT INTO posts 
          (title, status, content, gato_id) 
          VALUES 
          (:title, :status, :content, :gato_id)";

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
    $allowedFields = ['id', 'title', 'status', 'content', 'gato_id'];

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
    $allowedFields = ['id', 'title', 'status', 'content', 'gato_id'];

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

function updatePost($input, $db, $id){

    $fields = getParams($input);

    $sql = "
          UPDATE posts 
          SET $fields 
          WHERE id=$id
           ";

    $statement = $db->prepare($sql);

    bindAllValues($statement, $input);
    $statement->execute();

    return $id;
}

/**
 * Get all comments of the post
 *
 * @param $db
 * @param $postId
 * @return mixed fetchAll result
 */
/*function getMaullidos($db, $postId) {
    $statement = $db->prepare("
        SELECT maullidos.*, gatos.nombre as gato_nombre, gatos.dueno as gato_dueno, gatos.comida as gato_comida 
          FROM maullidos left join gatos on maullidos.gato_id = gatos.id
         WHERE post_id = $postId");
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    return $statement->fetchAll();
}*/

?>

