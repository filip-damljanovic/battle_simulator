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

  $game->game_name = $data->game_name;

  // Get games
  $games = $game->get_all();
  $num = $games->rowCount();

  // Check if there is more tha five games
  if($num >= 5) {
    echo json_encode(
      array('message' => 'Cannot have more than five games, sorry!')
    );
  } elseif($game->create()) {
    // Create game
    $id = $db->lastInsertId();
    
    echo json_encode(
      array(
        'message' => 'Game created successfuly',
        'id' => $id
      )
    );
  } else {
    echo json_encode(
      array('message' => 'Game not created, enter a game name!')
    );
  }
?>