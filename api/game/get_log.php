<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Game.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $game = new Game($db);

  // Get ID
  $game->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get game
  $game->get_log();

  // Create array
  $game = array(
    'id' => $game->id,
    'armies' => $game->armies,
    'game_units' => $game->game_units,
    'game_status' => $game->game_status
  );

  // Make JSON
  print_r(json_encode($game));