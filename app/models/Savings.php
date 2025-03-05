<?php
class Savings{
    private $conn;
    private $table = 'savings';

    public function __construct($database) {
        $this->conn = $database;
    }
    
    //Tambah savings
    public function addSavings($user_id, $amount, $message){
        $query = "INSERT INTO " . $this->table . " (user_id, amount, message) VALUES (:user_id, :amount, :message)";
        $stmt = $this->conn->prepare($query);
        
        //Bind placeholder dengan variabel
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':message', $message);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function history($user_id){
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function allSavings(){
        $query = "SELECT d.*, u.name FROM " . $this->table . " d
                  JOIN users u ON d.user_id = u.id
                  ORDER BY d.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalSavings($user_id) {
        $query = "SELECT SUM(amount) AS total FROM " . $this->table . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0; // Return 0 if no savings found
    }

    public function updateSaving($data) {
        // Modified to only update if the saving belongs to the user
        $this->db->query('UPDATE savings 
                          SET amount = :amount, description = :description, 
                              category = :category, date = :date 
                          WHERE id = :id AND user_id = :user_id');
        
        // Add user_id binding
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':date', $data['date']);
        
        // Rest of the method remains the same
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getSavingsByUser($user_id) {
        $query = "SELECT d.*, u.name FROM " . $this->table . " d
                  JOIN users u ON d.user_id = u.id
                  WHERE d.user_id = :user_id
                  ORDER BY d.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
