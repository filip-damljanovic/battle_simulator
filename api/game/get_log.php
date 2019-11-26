<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Game.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate game object
  $game = new Game($db);

  // Get ID
  $game->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get games
  $games = $game->get_all();
  $num = $games->rowCount();

  if($num > 0) {
    // Get game
    $game->get_log();

    // Create array
    $game = array(
      'id' => $game->id,
      'game_name' => $game->game_name,
      'armies_left' => $game->armies_left,
      'game_units' => $game->game_units,
      'game_status' => $game->game_status
    );

    // Make JSON
    print_r(json_encode($game));
  } else {
     echo json_encode(
      array('message' => 'No games found')
    );
  }
  