<?php
class Savings{
    private $connection;
    private $table = 'savings';

    public function _construct($database){
        $this->connection = $database;
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
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$user_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function allSavings(){
        $query = "SELECT d.*, u.name FROM " . $this->table . " d
                  JOIN users u ON d.user_id = u.id
                  ORDER BY d.created_at DESC";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
