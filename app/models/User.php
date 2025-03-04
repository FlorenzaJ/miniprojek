<?php
class User{
    private $connection;
    private $table = 'users';

    public function _construct($database){
        $this->connection = $database;
    }

    //Function untuk register user baru
    public function register($name, $email, $password, $role = 'user'){

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO " . $this->table . " (name, email, password, role) 
                  VALUES (:name, :email, :password, :role)";
        $stmt = $this->connection->prepare($query);

        //Bind placeholder dengan variabel
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $role);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Function untuk Login
    public function login($email, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if(password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_role'] = $row['role'];
                return $row;
            }
        }
        return false;
    }

    //List seluruh user terdaftar
    public function AllUsers() {
        $query = "SELECT id, name, email, role, created_at FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>