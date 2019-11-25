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

  // Instantiate blog post object
  $army = new Army($db);
  $game = new Game($db);

  // Get IDs
  $army->game_id = isset($_GET['id']) ? $_GET['id'] : die();
  $game->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Delete armies
  if($army->delete()) {
    // Reset game
    if($game->reset()) {
      echo json_encode(
        array('message' => 'Game reseted')
      );
    } else {
      echo json_encode(
        array('message' => 'Game not reset')
      );
    }
  } else {
    echo json_encode(
      array('message' => 'Armies Not Deleted')
    );
  }

?>