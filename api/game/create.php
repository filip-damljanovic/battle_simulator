<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Game.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate game object
  $game = new Game($db);

  // Get raw game data
  $data = json_decode(file_get_contents("php://input"));

  // Create game
  if($game->create()) {
    $id = $db->lastInsertId();

    echo json_encode(
      array(
        'message' => 'Game Created Successfuly',
        'id' => $id
      )
    );
  } else {
    echo json_encode(
      array('message' => 'Game Not Created')
    );
  }
?>