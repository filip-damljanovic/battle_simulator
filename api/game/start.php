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

  // Run attacks
  if($num > 1) {
    foreach($armies as $key => $army) {
      // Get attacker
      $attacker->get_attacker($army['id']);

      // Random strategy
      if($attacker->attack_strategy == 'random') {
        // Get Random Defender
        $defender->get_random_defender($attacker->id);
      } elseif($attacker->attack_strategy == 'weakest') {
        // Get Strongest Defender
        $defender->get_weakest_defender($attacker->id);
      } elseif($attacker->attack_strategy == 'strongest') {
        // Get Weakest Defender
        $defender->get_strongest_defender($attacker->id);
      }

      // Run attack
      if($armyInstance->runAttack($attacker, $defender)) {
        echo json_encode(
          array('message' => 'Attack Successful')
        );
      }
      else {
        echo json_encode(
          array('message' => 'Attack not successful')
        );
      }
    }
  } else {
    // Get winner
    $row = $armies->fetch(PDO::FETCH_ASSOC);
    $last_standing_army = $row['name'];

    echo json_encode(
      array('message' =>  'Game over. ' . $last_standing_army . ' wins!')
    );
  }
?>