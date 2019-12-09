<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Game.php';
  include_once '../../models/Army.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate game and army objects
  $game = new Game($db);
  $armyInstance = new Army($db);
  $attacker = new Army($db);
  $defender = new Army($db);

  // Get ID
  $game->id = isset($_GET['id']) ? $_GET['id'] : die();

  if($_GET['id'] == "Select game ID") {
    echo json_encode(
      array('message' =>  'Select game ID!')
    );
  } else {
    // Get Game
    $game->get();

    // Get all armies for a game
    $armies = $armyInstance->get_all($game->id);
    $num = $armies->rowCount();

    // Start game if conditions are met
    if($num > 0) {
      // There can be less than 10 armies if the game is in progress or finished
      if($num < 10 && $game->game_status == 'in progress') {
        // Run round of attacks
        $attacker->round_of_attacks($armies, $game, $attacker, $defender);
      } elseif($num >= 10 && $game->game_status == 'finished') {
        // Chek if armies have between 80 and 100 units
        foreach($armies as $key => $army) {
          if($army['units'] < 80) {
            // Set random units between 80 and 100 for armies that have less
            $armyInstance->set_random_units($army['id']);
          }
        }
        // Start the game
        $status = 'in progress';
        $game->update_game_status($status);

        echo json_encode(
          array('message' =>  'Armies set! Start running attacks!')
        );
      } elseif($num >= 10) {
        // Run round of attacks
        $attacker->round_of_attacks($armies, $game, $attacker, $defender);
      } else {
        echo json_encode(
          array('message' =>  'Not enough armies to start the battle. There must be a minimum of 10 armies!')
        );
      }
    } else {
      echo json_encode(
        array('message' =>  'No armies in the game!')
      );
    }
  }

?>