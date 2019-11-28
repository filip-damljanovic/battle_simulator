<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: UPDATE, DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Army.php';
  include_once '../../models/Game.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate army and game object
  $army = new Army($db);
  $game = new Game($db);
  
  // Get IDs
  $army->game_id = isset($_GET['id']) ? $_GET['id'] : die();
  $game->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get games
  $result = $game->get_all();
  
  // Get row count
  $num = $result->rowCount();

  if($game->id == "Select game ID") {
    echo json_encode(
      array('message' =>  'Select game ID!')
    );
  } elseif($num > 0) {
    // Reset game
    if($game->reset() && $army->delete()) {
      echo json_encode(
        array('message' => 'Game successfuly reseted! Check game log!')
      );
    } else {
      echo json_encode(
        array('message' => 'Something went wrong! Game not reseted!')
      );
    }
  } else {
    echo json_encode(
      array('message' => 'No games found!')
    );
  }

?>