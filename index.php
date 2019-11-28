<?php
  include_once 'config/Database.php';
  include_once 'models/Game.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate game object
  $game = new Game($db);

  // Get games
  $games = $game->get_all();
  $num = $games->rowCount();

  // Game IDs Array
  $game_ids = array();

  foreach($games as $key => $igra) {
    array_push($game_ids, $igra['id']);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Battle simulator - REST API</title>

  <style>
    body {
      text-align: center;
      font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
      background-image: url(img/battle_background.jpg);
      background-repeat: no-repeat;
      background-size: cover;
    }
    h1 {
      font-size: 2em;
      font-weight: bold;
      color: bisque;
    }
    .message h1 {
      color: brown;
    }
    label {
      color: bisque;
    }
    input, select {
      background: bisque;
      border: none;
      box-shadow: none;
      padding: 5px;
      margin-top: 5px;
      border-radius: 5px;
    }
    .box {
      border-radius: 5px;
      background-color: #eee;
      padding: 20px;
      padding-bottom: 50px;
    }
    button {
      color: bisque;
      background-color: brown;
      border-radius: 5px;
      border: 1px solid brown;
      padding: 5px 10px 8px 10px;
    }
    button:hover {
      cursor: pointer;
      background-color: #0F5897;
      border: 1px solid #0F5897;
    }
    .game {
      font-size: 18px;
    }
    .game strong {
      color: brown;
    }
    table {
      width: 100%;
    }
    table td, table th {
      border: 1px solid #ddd;
      padding: 8px;
    }
    table tr:nth-child(even){background-color: #f4f4f4;}
    table tr:hover {background-color: #ddd;}
    table th {
      padding-top: 12px;
      padding-bottom: 12px;
      background-color: brown;
      color: white;
    }
    ::placeholder {
      color: brown;
      font-style: italic;
    }
    @media(max-width: 576px) {
      .container {
        flex-direction: column;
      }
      .get, .post {
        width: 100% !important;
      }
    }
  </style>
</head>
<body>

<div style="display: flex; justify-content: space-around;" class="container">
  <div style="width:50%;" class="post">
    <!-- CREATE GAME FORM -->
    <div>
      <h1>Create game</h1>
      <form id="game_form">
        <!-- Game name input -->
        <label for="game_name">Game name</label><br>
        <input id="game_name" style="margin-bottom: 10px" type="text" name="game_name" placeholder="Game name"
          autocomplete="on"><br>
      </form>
      <!-- Create game -->
      <button id="create_game">Create Game</button>
    </div>
    
    <!-- ADD ARMY FORM -->
    <div>
      <h1>Add army to a game</h1>
      <form id="army_form">
        <!-- Game ID input -->
        <label for="game_id">Select game ID</label><br>
        <select style="margin-bottom: 10px" name="game_id" id="game_id_2">
          <option default>Select game ID</option>
          <?php
          // Add game IDs to select options
          foreach($game_ids as $key => $game_id) {
            echo "<option value='$game_id'>$game_id</option>";
          }
          ?>
        </select><br>
        <!-- Army name input -->
        <label for="name">Army name</label><br>
        <input style="margin-bottom: 10px" type="text" name="name" placeholder="Army name" autocomplete="on"><br>
        <!-- Army units input -->
        <label for="units">Units</label><br>
        <select style="margin-bottom: 10px" name="units">
          <option default>Select number of units</option>
          <option value="80">80</option>
          <option value="81">81</option>
          <option value="82">82</option>
          <option value="83">83</option>
          <option value="84">84</option>
          <option value="85">85</option>
          <option value="86">86</option>
          <option value="87">87</option>
          <option value="88">88</option>
          <option value="89">89</option>
          <option value="90">90</option>
          <option value="91">91</option>
          <option value="92">92</option>
          <option value="93">93</option>
          <option value="94">94</option>
          <option value="95">95</option>
          <option value="96">96</option>
          <option value="97">97</option>
          <option value="98">98</option>
          <option value="99">99</option>
          <option value="100">100</option>
        </select><br>
        <!-- Attack strategy input -->
        <label for="attack_strategy">Attack Strategy</label><br>
        <select style="margin-bottom: 10px" name="attack_strategy">
          <option default>Select attack strategy</option>
          <option value="random">random</option>
          <option value="strongest">strongest</option>
          <option value="weakest">weakest</option>
        </select><br>
        <!-- Create army -->
        <button id="create_army">Add army</button>
      </form>
    </div>

    <!-- START A GAME -->
    <div>
      <h1>Start a game</h1>
      <label for="id">Select game ID</label><br>
      <select style="margin-bottom: 10px" name="id" id="game_id_3">
        <option default>Select game ID</option>
        <?php
          // Add game IDs to select options
          foreach($game_ids as $key => $game_id) {
            echo "<option value='$game_id'>$game_id</option>";
          }
        ?>
      </select><br>
      <!-- Start a game -->
      <button id="start_game">Run attacks</button>
    </div>

    <!-- RESET A GAME -->
    <div>
      <h1>Reset a game</h1>
      <label for="id">Select game ID</label><br>
      <select style="margin-bottom: 10px" name="id" id="game_id_4">
        <option default>Select game ID</option>
        <?php
          // Add game IDs to select options
          foreach($game_ids as $key => $game_id) {
            echo "<option value='$game_id'>$game_id</option>";
          }
        ?>
      </select><br>
      <!-- Reset a game -->
      <button id="reset_game">Reset a game</button>
    </div>
  </div>

  <div style="width:50%;" class="get">
    <!-- GET EXISTING GAMES -->
    <div>
      <h1>Get games</h1>
      <p class="message box">Get existing games</p>
      <p><button id="get_games">Get games</button></p>
    </div>

    <!-- GET GAME LOG -->
    <div>
      <h1>Get game log</h1>
      <label for="id">Select game ID</label><br>
      <select style="margin-bottom: 10px" name="id" id="game_id_1">
        <option default>Select game ID</option>
        <?php
          // Add game IDs to select options
          foreach($game_ids as $key => $game_id) {
            echo "<option value='$game_id'>$game_id</option>";
          }
        ?>
      </select><br>
      <p class="message box">Get game log for selected ID</p>
      <p><button id="get_game_log">Get game log</button></p>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="ajax.js"></script>
</body>
</html>