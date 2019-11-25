<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Army.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate army and game objects
  $army = new Army($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $army->game_id = $data->game_id;
  $army->name = $data->name;
  $army->units = $data->units;
  $army->attack_strategy = $data->attack_strategy;

  // Create army
  if($army->create()) { 
    echo json_encode(
      array('message' => 'Army Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Army Not Created')
    );
  }
?>