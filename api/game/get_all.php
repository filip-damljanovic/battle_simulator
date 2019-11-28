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

  // Get games
  $result = $game->get_all();
  
  // Get row count
  $num = $result->rowCount();

  // Check if teheres any games
  if($num > 0) {
    // Game array
    $game_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $game_item = array(
        'Game ID' => $id,
        'Name' => $game_name,
        'Total units in the game' => $game_units,
        'Status' => $game_status
      );

      // Push to "games"
      array_push($game_arr, $game_item);
    }
    // Turn to JSON & output
    echo json_encode($game_arr);

  } else {
    // No Games
    echo json_encode(
      array(array('message' => 'No Games Found'))
    );
  }
?>