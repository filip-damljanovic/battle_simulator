<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Game.php';
  include_once '../../models/Army.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate game object
  $game = new Game($db);
  $armyInstance = new Army($db);

  // Get ID
  $game->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get games
  $games = $game->get_all();
  $num = $games->rowCount();

  // Get armies
  $armies = $armyInstance->get_all($game->id);
  $armies_arr = array();

  // Create armies array
  foreach($armies as $key => $army) {
    $army_arr = array(
      'name' => $army['name'],
      'units' => $army['units'],
      'attack_strategy' => $army['attack_strategy']
    );
    array_push($armies_arr, $army_arr);
  }

  if($game->id == "Select game ID") {
    echo json_encode(
      array('message' =>  'Select game ID!')
    );
  } elseif($num > 0) {
    // Get game
    $game->get_log();

    // Create array
    $game = array(
      'Name' => $game->game_name,
      'armies_left' => $armies_arr,
      'Total army units in the game' => $game->game_units,
      'Status' => $game->game_status
    );

    // Make JSON
    print_r(json_encode($game));
  } else {
     echo json_encode(
      array('message' => 'No games found')
    );
  }

?>