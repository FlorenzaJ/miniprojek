<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'tabungan_db';
    private $username = 'root';
    private $password = '';
    private $connect;

    public function connect(){
        try{
            $this->connect = new PDO(
            "mysql:host={$this->host};dbname={$this->db_name}",
            $this->username,
            $this->password
        );
        $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->connect;
    } catch(PDOException $e) {
        echo "Connection Error: " . $e->getMessage();
        return null;
        }
    }
}
?>
