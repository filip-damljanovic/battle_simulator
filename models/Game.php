<?php 
  class Game {
    // DB stuff
    private $conn;
    private $table = 'games';

    // Game Properties
    public $id;
    public $game_status;
    // public $game_units;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Single Game
    public function get() {
      // Create query
      $query = 'SELECT 
                  g.id, COUNT(a.game_id) AS armies, g.game_status 
                FROM 
                  ' . $this->table . ' g
                LEFT JOIN 
                  armies a ON g.id = a.game_id
                WHERE
                  g.id = ?
                LIMIT 0,1';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set properties
      $this->id = $row['id'];
      $this->armies = $row['armies'];
      $this->game_status = $row['game_status'];
    }

    // Get all games
    public function get_all() {
      // Create query
      $query = 'SELECT 
                  g.id, SUM(a.units) AS game_units, g.game_status 
                FROM 
                  ' . $this->table . ' g
                LEFT JOIN 
                  armies a ON g.id = a.game_id
                GROUP BY 
                  g.id';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Game Log
    public function get_log() {
      // Create query
      $query = 'SELECT 
                  g.id, COUNT(a.game_id) AS armies, SUM(a.units) AS game_units, g.game_status 
                FROM 
                  ' . $this->table . ' g
                LEFT JOIN 
                  armies a ON g.id = a.game_id
                WHERE
                  g.id = ?
                LIMIT 0,1';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set properties
      $this->id = $row['id'];
      $this->armies = $row['armies'];
      $this->game_units = $row['game_units'];
      $this->game_status = $row['game_status'];
    }

    // Create Game
    public function create() {
      // Create query
      $query = 'INSERT INTO ' . $this->table . ' SET game_status = "offline"';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Start Game
    public function update() {
      // Create query
      $query = 'UPDATE ' . $this->table . '
                            SET 
                              game_status = "online"
                            WHERE 
                              id = ?';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Reset Game
    public function reset() {
      // Create query
      $query = 'UPDATE ' . $this->table . '
                            SET 
                              game_status = "offline"
                            WHERE 
                              id = ?';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
  }
?>