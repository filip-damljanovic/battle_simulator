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

  // Get Game
  $game->get();

  // Get all armies for a game
  $armies = $armyInstance->get_all($game->id);
  $num = $armies->rowCount();

  if($num > 0) {
    // Check if there are enough armies to start a game
    if($num < 10 && ($game->game_status == 'in progress' || $game->game_status == 'finished')) {
      $attacker->round_of_attacks($armies, $game, $attacker, $defender);
    } elseif($num >= 10) {
      $attacker->round_of_attacks($armies, $game, $attacker, $defender);
    } else {
      echo json_encode(
        array('message' =>  'Not enough armies to start the battle. There must be a minimum of 10 armies!')
      );
    }
  } else {
    echo json_encode(
      array('message' =>  'No games found!')
    );
  }
  
?>