<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Army.php';
  include_once '../../models/Game.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate army and game objects
  $army = new Army($db);
  $game = new Game($db);

  // Get games
  $games = $game->get_all();
  $num = $games->rowCount();

  // Check if there are games
  if($num <= 0) {
    echo json_encode(
      array('message' => 'Create a game first!')
    );
  } else {
    // Get raw army data
    $data = json_decode(file_get_contents("php://input"));

    $army->game_id = $data->game_id;
    $army->name = $data->name;
    $army->units = $data->units;
    $army->attack_strategy = $data->attack_strategy;

    // Get game for army
    $game->id = $army->game_id;
    $game->get();

    // Create army
    if($data->units == "Select number of units" || $data->attack_strategy == "Select attack strategy" || $data->game_id == "Select game ID") {
      echo json_encode(
        array('message' => 'Army not created, fill out all the fields!')
      );
    } elseif($game->game_status == 'in progress') {
      // Add new armies to the beginning in between turns
      $army->get_min_id_army($game->id);
      $army->increment_army_id($army->id);
      $army->create_army_for_game_in_progress($army->id);

      echo json_encode(
        array('message' => 'Army added to ' . $game->game_name . ' successfuly!')
      );
    } elseif($army->create()) {
      echo json_encode(
        array('message' => 'Army added to ' . $game->game_name . ' successfuly!')
      );
    } else {
      echo json_encode(
        array('message' => 'Army not created, fill out all the fields!')
      );
    }
  }
?>