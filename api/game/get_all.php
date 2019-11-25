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

  // Game read query
  $result = $game->get_all();
  
  // Get row count
  $num = $result->rowCount();

  // Check if teheres any games
  if($num > 0) {
    // Game array
    $game_arr = array();
    $game_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $game_item = array(
        'id' => $id,
        'game_units' => $game_units,
        'game_status' => $game_status
      );

      // Push to "data"
      array_push($game_arr['data'], $game_item);
    }
    // Turn to JSON & output
    echo json_encode($game_arr);

  } else {
    // No Games
    echo json_encode(
      array('message' => 'No Games Found')
    );
  }
?>