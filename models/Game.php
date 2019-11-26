<?php 
  class Game {
    // DB stuff
    private $conn;
    private $table = 'games';

    // Game Properties
    public $id;
    public $game_name;
    public $game_status;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get single game
    public function get() {
      // Create query
      $query = 'SELECT 
                  g.id, g.game_name, COUNT(a.game_id) AS armies, g.game_status 
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
      $this->game_name = $row['game_name'];
      $this->armies = $row['armies'];
      $this->game_status = $row['game_status'];
    }

    // Get all games
    public function get_all() {
      // Create query
      $query = 'SELECT 
                  g.id, g.game_name, SUM(a.units) AS game_units, g.game_status 
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

    // Get fame log
    public function get_log() {
      // Create query
      $query = 'SELECT 
                  g.id, g.game_name, g.game_status, COUNT(a.game_id) AS armies_left, SUM(a.units) AS game_units 
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
      $this->game_name = $row['game_name'];
      $this->armies_left = $row['armies_left'];
      $this->game_units = $row['game_units'];
      $this->game_status = $row['game_status'];
    }

    // Create game
    public function create() {
      // Create query
      $query = 'INSERT INTO ' . $this->table . ' 
                                SET  
                                  game_name = :game_name, game_status = "not started"';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->game_name = htmlspecialchars(strip_tags($this->game_name));

      // Bind data
      $stmt->bindParam(':game_name', $this->game_name);

      // Check if field is empty
      if(!empty($this->game_name)) {
        // Execute query
        if($stmt->execute()) {
          return true;
        }
      } else {
        return false;
      }
    }

    // Change game status
    public function update_game_status($status) {
      // Create query
      $query = 'UPDATE ' . $this->table . '
                            SET 
                              game_status = :game_status
                            WHERE 
                              id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':game_status', $status);

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
                              game_status = "not started"
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