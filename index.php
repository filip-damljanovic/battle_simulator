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
      font-family: "Helvetica", sans-serif;
    }
    h1 {
      font-size: 2em;
      font-weight: bold;
    }
    .box {
      border-radius: 5px;
      background-color: #eee;
      padding: 20px 5px;
    }
    button {
      color: white;
      background-color: #4791d0;
      border-radius: 5px;
      border: 1px solid #4791d0;
      padding: 5px 10px 8px 10px;
    }
    button:hover {
      background-color: #0F5897;
      border: 1px solid #0F5897;
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
           <?php
            // Add game IDs to select options
            foreach($game_ids as $key => $game_id) {
              echo "<option selected value='$game_id'>$game_id</option>";
            }
          ?>
        </select><br>
        <!-- Army name input -->
        <label for="name">Army name</label><br>
        <input style="margin-bottom: 10px" type="text" name="name" placeholder="Army name" autocomplete="on"><br>
        <!-- Army units input -->
        <label for="units">Units</label><br>
        <select style="margin-bottom: 10px" name="units">
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
        <?php
          // Add game IDs to select options
          foreach($game_ids as $key => $game_id) {
            echo "<option selected value='$game_id'>$game_id</option>";
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
        <?php
          // Add game IDs to select options
          foreach($game_ids as $key => $game_id) {
            echo "<option selected value='$game_id'>$game_id</option>";
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
      <h1>Get Games</h1>
      <p class="message box">Get Existing Games</p>
      <p><button id="get_games">Get Games</button></p>
    </div>

    <!-- GET GAME LOG -->
    <div>
      <h1>Get Game Log</h1>
      <label for="id">Select game ID</label><br>
      <select style="margin-bottom: 10px" name="id" id="game_id_1">
        <?php
          // Add game IDs to select options
          foreach($game_ids as $key => $game_id) {
            echo "<option selected value='$game_id'>$game_id</option>";
          }
        ?>
      </select><br>
      <p class="message box">Get Game Log For Selected ID</p>
      <p><button id="get_game_log">Get Game Log</button></p>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="ajax.js"></script>
</body>
</html>