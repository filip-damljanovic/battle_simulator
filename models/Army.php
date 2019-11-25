<?php 
  class Army {
    // DB stuff
    private $conn;
    private $table = 'armies';

    // Army Properties
    public $id;
    public $game_id;
    public $units;
    public $attack_strategy;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Create Army
    public function create() {
      // Create query
      $query = 'INSERT INTO ' . $this->table . ' SET game_id = :game_id, name= :name, units = :units, attack_strategy = :attack_strategy';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->game_id = htmlspecialchars(strip_tags($this->game_id));
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->units = htmlspecialchars(strip_tags($this->units));
      $this->attack_strategy = htmlspecialchars(strip_tags($this->attack_strategy));

      // Bind data
      $stmt->bindParam(':game_id', $this->game_id);
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':units', $this->units);
      $stmt->bindParam(':attack_strategy', $this->attack_strategy);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Reset Game - Delete Armies From A Game
    public function delete() {
      // Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE game_id = :game_id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->game_id = htmlspecialchars(strip_tags($this->game_id));

      // Bind data
      $stmt->bindParam(':game_id', $this->game_id);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Get all armies
    public function get_all($game_id) {
      // Create query
      $query = 'SELECT 
                  * 
                FROM 
                  ' . $this->table . '
                WHERE
                  game_id = :id';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $game_id = htmlspecialchars(strip_tags($game_id));

      // Bind data
      $stmt->bindParam(':id', $game_id);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get attacker
    public function get_attacker($attacker_id) {
      // Create query
      $query = 'SELECT 
                  *
                FROM 
                  ' . $this->table . '
                WHERE
                  id = :id
                LIMIT 0,1';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind IDs
      $stmt->bindParam(':id', $attacker_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set properties
      $this->id = $row['id'];
      $this->game_id = $row['game_id'];
      $this->name = $row['name'];
      $this->units = $row['units'];
      $this->attack_strategy = $row['attack_strategy'];
    }

    // Get random defender
    public function get_random_defender($attacker_id) {
      // Create query
      $query = 'SELECT 
                  *
                FROM 
                  ' . $this->table . '
                WHERE
                  id <> :id
                ORDER BY 
                  RAND()
                LIMIT 1';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind IDs
      $stmt->bindParam(':id', $attacker_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set properties
      $this->id = $row['id'];
      $this->game_id = $row['game_id'];
      $this->name = $row['name'];
      $this->units = $row['units'];
      $this->attack_strategy = $row['attack_strategy'];
    }

    // Get weakest defender
    public function get_weakest_defender($attacker_id) {
      // Create query
      $query = 'SELECT 
                  *
                FROM 
                  ' . $this->table . '
                WHERE
                  id <> :id
                AND
                  units = (SELECT MIN(units) FROM ' . $this->table . ' WHERE id <> :id)';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind IDs
      $stmt->bindParam(':id', $attacker_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set properties
      $this->id = $row['id'];
      $this->game_id = $row['game_id'];
      $this->name = $row['name'];
      $this->units = $row['units'];
      $this->attack_strategy = $row['attack_strategy'];
    }

    // Get strongest defender
    public function get_strongest_defender($attacker_id) {
      // Create query
      $query = 'SELECT 
                  *
                FROM 
                  ' . $this->table . '
                WHERE
                  id <> :id
                AND
                  units = (SELECT MAX(units) FROM ' . $this->table . ' WHERE id <> :id)';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind IDs
      $stmt->bindParam(':id', $attacker_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set properties
      $this->id = $row['id'];
      $this->game_id = $row['game_id'];
      $this->name = $row['name'];
      $this->units = $row['units'];
      $this->attack_strategy = $row['attack_strategy'];
    }

    // Update defender units
    public function update_defender_units($defender) {
      // Create query
      $query = 'UPDATE ' . $this->table . '
                            SET
                              units = :units
                            WHERE 
                              id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $defender->id = htmlspecialchars(strip_tags($defender->id));
      $defender->units = htmlspecialchars(strip_tags($defender->units));

      // Bind data
      $stmt->bindParam(':id', $defender->id);
      $stmt->bindParam(':units', $defender->units);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Delete army when its destroyed
    public function delete_destroyed($defender) {
      // Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $defender->id = htmlspecialchars(strip_tags($defender->id));

      // Bind data
      $stmt->bindParam(':id', $defender->id);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Run attack
    public function runAttack ($attacker, $defender) {
      // Check if attack is successful
      if ($attacker->units > rand(1, 100)) {

        $damage = $attacker->units / 2;
        $defender->units = $defender->units - $damage;

        // Update defender units after successful attack
        $this->update_defender_units($defender);

        if ($defender->units <= 0) {
          // Army destroyed
          $this->delete_destroyed($defender);
        }

        return true;
      } else {
          return false;
      }
    }

  }
?>